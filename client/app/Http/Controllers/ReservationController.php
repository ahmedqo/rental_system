<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Models\Payment;
use App\Models\Recovery;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class ReservationController extends Controller
{
    public function index_view()
    {
        return view('reservation.index');
    }

    public function store_view()
    {
        return view('reservation.store');
    }

    public function patch_view($id)
    {
        $data = Reservation::with('Client', 'Vehicle', 'Agency')->findorfail($id);
        return view('reservation.patch', compact('data'));
    }

    public function print_view($id)
    {
        $data = Reservation::with('Client', 'SClient', 'Vehicle', 'Agency', 'Payment', 'Recovery')->findorfail($id);
        return view('reservation.print', compact('data'));
    }

    public function search_action(Request $Request)
    {
        $data = Reservation::with([
            'Vehicle' =>  function ($Query) {
                $Query->select('id', "brand", 'model', 'year', 'registration_number');
            },
            'Client' =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'SClient'  =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Agency' =>  function ($Query) {
                $Query->select('id', "name");
            }
        ])->where('company', Core::company('id'))->where('status', '!=', 'completed')->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function filter_action(Request $Request)
    {
        $data = Reservation::with([
            'Vehicle' =>  function ($Query) {
                $Query->select('id', "brand", 'model', 'year', 'registration_number');
            },
            'Client' =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'SClient'  =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Agency' =>  function ($Query) {
                $Query->select('id', "name");
            }
        ])->where('company', Core::company('id'))->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function store_action(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'renter' => ['required', 'string'],
            'vehicle' => ['required', 'integer'],
            'agency' => ['required_if:renter,agency', 'integer'],
            'client' => ['required_if:renter,individual', 'integer'],
            'secondary_client' => ['nullable', 'integer', 'different:client'],

            'pickup_date' => ['required', 'date', 'after_or_equal:today'],
            'dropoff_date' => ['required', 'date', 'after:pickup_date'],
            'pickup_time' => ['required', 'string'],
            'dropoff_time' => ['required', 'string'],
            'mileage' => ['required', 'numeric'],
            'fuel_level' => ['required', 'numeric'],
            'daily_rate' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        $pickup = Carbon::parse($Request->pickup_date . ' ' . $Request->pickup_time);
        $dropoff = Carbon::parse($Request->dropoff_date . ' ' . $Request->dropoff_time);
        $rental_period_days = (int) ceil($pickup->diffInHours($dropoff) / 24);
        $total = $rental_period_days * $Request->daily_rate;

        $key = $Request->renter == 'individual' ? 'agency' : 'client';
        $payment = collect(json_decode($Request->payment));

        $Request->merge([
            $key => null,
            'pickup_date' => $pickup,
            'reference' => Core::ref(Reservation::class),
            'condition' => $Request->condition,
            'dropoff_date' => $dropoff,
            'rental_period_days' => $rental_period_days,
            'status' => $payment->sum('amount') >= $total ? 'completed' : 'pending'
        ]);

        $Reservation = Reservation::create($Request->all());

        Payment::create([
            'reservation' => $Reservation->id,
            'daily_rate' => $Request->daily_rate,
            'logs' => $Request->payment,
            'total' => $total,
            'paid' => $payment->sum('amount'),
            'rest' => $total - $payment->sum('amount'),
            'status' => $payment->sum('amount') >= $total ? 'completed' : 'pending'
        ]);

        Recovery::create([
            'reservation' => $Reservation->id,
            'mileage' => $Request->mileage + ($rental_period_days * Core::company('mileage_per_day')),
            'fuel_level' => $Request->fuel_level,
            'condition' => $Request->condition,
            'penalties' => '[]',
            'status' => $payment->sum('amount') >= $total ? 'completed' : 'pending'
        ]);

        return Redirect::back()->with([
            'message' => __('Created successfully'),
            'type' => 'success'
        ]);
    }

    public function patch_action(Request $Request, $id)
    {
        $validator = Validator::make($Request->all(), [
            'renter' => ['required', 'string'],
            'vehicle' => ['required', 'integer'],
            'agency' => ['required_if:renter,agency', 'integer'],
            'client' => ['required_if:renter,individual', 'integer'],
            'secondary_client' => ['nullable', 'integer', 'different:client'],

            'pickup_date' => ['required', 'date', 'after_or_equal:today'],
            'dropoff_date' => ['required', 'date', 'after:pickup_date'],
            'pickup_time' => ['required', 'string'],
            'dropoff_time' => ['required', 'string'],
            'mileage' => ['required', 'numeric'],
            'fuel_level' => ['required', 'numeric'],
            'daily_rate' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        $pickup = Carbon::parse($Request->pickup_date . ' ' . $Request->pickup_time);
        $dropoff = Carbon::parse($Request->dropoff_date . ' ' . $Request->dropoff_time);
        $rental_period_days = (int) ceil($pickup->diffInHours($dropoff) / 24);
        $total = $rental_period_days * $Request->daily_rate;

        $key = $Request->renter == 'individual' ? 'agency' : 'client';
        $payment = collect(json_decode($Request->payment));

        $Request->merge([
            $key => null,
            'pickup_date' => $pickup,
            'dropoff_date' => $dropoff,
            'condition' => $Request->condition,
            'rental_period_days' => $rental_period_days,
            'status' => $payment->sum('amount') >= $total ? 'completed' : 'pending'
        ]);

        $Reservation = Reservation::findorfail($id);
        $Reservation->update($Request->all());

        $Reservation->Payment->update([
            'daily_rate' => $Request->daily_rate,
            'logs' => $Request->payment,
            'total' => $total,
            'paid' => $payment->sum('amount'),
            'rest' => $total - $payment->sum('amount'),
            'status' => $payment->sum('amount') >= $total ? 'completed' : 'pending'
        ]);

        $Reservation->Recovery->update([
            'mileage' => $Request->mileage + ($rental_period_days * Core::company('mileage_per_day')),
            'fuel_level' => $Request->fuel_level,
            'condition' => $Request->condition,
            'status' => $payment->sum('amount') >= $total ? 'completed' : 'pending'
        ]);

        return Redirect::back()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }
}
