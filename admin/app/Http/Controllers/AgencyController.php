<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Models\Agency;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class AgencyController extends Controller
{
    public function index_view()
    {
        return view('agency.index');
    }

    public function store_view()
    {
        return view('agency.store');
    }

    public function patch_view($id)
    {
        $data = Agency::findorfail($id);
        return view('agency.patch', compact('data'));
    }

    public function scene_view($id)
    {
        $data = Agency::with('Owner')->findorfail($id);

        [$startDate, $endDate, $columns] = Core::getDates();

        $vals = Reservation::where('reservations.agency', $id)
            ->whereBetween('reservations.created_at', [$startDate, $endDate])
            ->join('payments', 'reservations.id', '=', 'payments.reservation')
            ->selectRaw('
                COUNT(DISTINCT reservations.id) as count,
                SUM(reservations.rental_period_days) as period,
                SUM(payments.total) as total,
                SUM(payments.paid) as paid,
                SUM(payments.rest) as rest
            ')
            ->first() ?? (object) [
                'count' => 0,
                'period' => 0,
                'total' => 0,
                'paid' => 0,
                'rest' => 0
            ];

        $vals->ended = Reservation::where('agency', $id)->where('status', '!=', 'completed')
            ->where('dropoff_date', '<', now())->count();

        return view('agency.scene', compact('data', 'vals'));
    }

    public function chart_action($id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = [
            'payments' => array_slice($columns, 0),
            'creances' => array_slice($columns, 0),
        ];

        Reservation::with('Payment')->where('agency', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()->groupBy(function ($model) {
                return Core::groupKey($model);
            })->each(function ($group, $key) use (&$data) {
                $group->each(function ($carry) use (&$data, &$key) {
                    $data['creances'][$key] += $carry->Payment->rest;
                    $data['payments'][$key] += $carry->Payment->paid;
                });
            });

        return response()->json([
            'data' => [
                'keys' => array_keys($columns),
                'payments' => array_values($data['payments']),
                'creances' => array_values($data['creances']),
            ]
        ]);
    }

    public function search_action(Request $Request)
    {
        $data = Agency::with('Owner')->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function search_all_action(Request $Request)
    {
        $data = Agency::orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function search_reservations_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Owner', 'Vehicle')->where('agency', $id)->where('status', '!=', 'completed')->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function filter_reservations_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Owner', 'Vehicle')->where('agency', $id)->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function search_payments_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Owner', 'Vehicle', 'Payment')->where('agency', $id)->where('status', '!=', 'completed')->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            return collect([
                'reference' => $carry->reference,
                'vehicle' => $carry->Vehicle
            ])->merge($carry->Payment);
        });
        return response()->json($data);
    }

    public function filter_payments_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Owner', 'Vehicle', 'Payment')->where('agency', $id)->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            return collect([
                'reference' => $carry->reference,
                'vehicle' => $carry->Vehicle
            ])->merge($carry->Payment);
        });
        return response()->json($data);
    }

    public function search_recoveries_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Owner', 'Vehicle', 'Recovery')->where('agency', $id)->where('status', '!=', 'completed')->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            return collect([
                'reference' => $carry->reference,
                'vehicle' => $carry->Vehicle
            ])->merge($carry->Recovery);
        });
        return response()->json($data);
    }

    public function filter_recoveries_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Owner', 'Vehicle', 'Recovery')->where('agency', $id)->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            return collect([
                'reference' => $carry->reference,
                'vehicle' => $carry->Vehicle
            ])->merge($carry->Recovery);
        });
        return response()->json($data);
    }

    public function store_action(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'name' => ['required', 'string'],
            'phone' => ['required', 'string', 'unique:agencies,phone'],
            'email' => ['required', 'email', 'unique:agencies,email'],

            'city' => ['required', 'string'],
            'zipcode' => ['required', 'numeric'],
            'address' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        Agency::create($Request->merge([
            'name' => strtolower($Request->name),
        ])->all());

        return Redirect::back()->with([
            'message' => __('Created successfully'),
            'type' => 'success'
        ]);
    }

    public function patch_action(Request $Request, $id)
    {
        $validator = Validator::make($Request->all(), [
            'name' => ['required', 'string'],
            'phone' => ['required', 'string', 'unique:agencies,phone,' . $id],
            'email' => ['required', 'email', 'unique:agencies,email,' . $id],

            'city' => ['required', 'string'],
            'zipcode' => ['required', 'numeric'],
            'address' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        $Agency = Agency::findorfail($id);
        $Agency->update($Request->merge([
            'name' => strtolower($Request->name),
        ])->all());

        return Redirect::back()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }

    public function clear_action($id)
    {
        Agency::findorfail($id)->delete();

        return Redirect::route('views.agencies.index')->with([
            'message' => __('Deleted successfully'),
            'type' => 'success'
        ]);
    }
}
