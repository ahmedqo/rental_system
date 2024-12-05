<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Models\Client;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use stdClass;

class ClientController extends Controller
{
    public function index_view()
    {
        return view('client.index');
    }

    public function store_view()
    {
        return view('client.store');
    }

    public function patch_view($id)
    {
        $data = Client::findorfail($id);
        return view('client.patch', compact('data'));
    }

    public function scene_view($id)
    {
        $data = Client::with('Restriction')->findorfail($id);

        [$startDate, $endDate, $columns] = Core::getDates();

        $vals = Reservation::where('reservations.client', $id)
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
                'rest' => 0,
            ];

        $vals->ended = Reservation::where('client', $id)->where('status', '!=', 'completed')
            ->where('dropoff_date', '<', now())->count();

        return view('client.scene', compact('data', 'vals'));
    }

    public function chart_action($id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = [
            'payments' => array_slice($columns, 0),
            'creances' => array_slice($columns, 0),
        ];

        Reservation::with('Payment')->where('client', $id)
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
        $data = Client::with('Restriction')->where('company', Core::company('id'))->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function search_all_action(Request $Request)
    {
        $data = Client::with('Restriction')->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function search_reservations_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Vehicle')->where('client', $id)->where('status', '!=', 'completed')->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function filter_reservations_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Vehicle')->where('client', $id)->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function search_payments_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Vehicle', 'Payment')->where('client', $id)->where('status', '!=', 'completed')->whereBetween('created_at', [$startDate, $endDate]);
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

        $data = Reservation::with('Vehicle', 'Payment')->where('client', $id)->whereBetween('created_at', [$startDate, $endDate]);
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

        $data = Reservation::with('Vehicle', 'Recovery')->where('client', $id)->where('status', '!=', 'completed')->whereBetween('created_at', [$startDate, $endDate]);
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

        $data = Reservation::with('Vehicle', 'Recovery')->where('client', $id)->whereBetween('created_at', [$startDate, $endDate]);
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
            'identity_type' => ['required', 'string'],
            'identity_number' => ['required', 'string', 'unique:clients,identity_number'],
            'identity_issued_in' => ['required', 'string'],
            'identity_issued_at' => ['required', 'date'],

            'license_number' => ['required', 'string', 'unique:clients,license_number'],
            'license_issued_in' => ['required', 'string'],
            'license_issued_at' => ['required', 'date'],

            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:clients,email'],
            'phone' => ['required', 'string', 'unique:clients,phone'],
            'nationality' => ['required', 'string'],

            'gender' => ['required', 'string'],
            'birth_date' => ['required', 'date'],
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

        Client::create($Request->merge([
            'first_name' => strtolower($Request->first_name),
            'last_name' => strtolower($Request->last_name)
        ])->all());

        return Redirect::back()->withInput()->with([
            'message' => __('Created successfully'),
            'type' => 'success'
        ]);
    }

    public function patch_action(Request $Request, $id)
    {
        $validator = Validator::make($Request->all(), [
            'identity_type' => ['required', 'string'],
            'identity_number' => ['required', 'string', 'unique:clients,identity_number,' . $id],
            'identity_issued_in' => ['required', 'string'],
            'identity_issued_at' => ['required', 'date'],

            'license_number' => ['required', 'string', 'unique:clients,license_number,' . $id],
            'license_issued_in' => ['required', 'string'],
            'license_issued_at' => ['required', 'date'],

            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:clients,email,' . $id],
            'phone' => ['required', 'string', 'unique:clients,phone,' . $id],
            'nationality' => ['required', 'string'],

            'gender' => ['required', 'string'],
            'birth_date' => ['required', 'date'],
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

        $Client = Client::findorfail($id);
        $Client->update($Request->merge([
            'first_name' => strtolower($Request->first_name),
            'last_name' => strtolower($Request->last_name)
        ])->all());

        return Redirect::back()->withInput()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }

    public function clear_action($id)
    {
        Client::findorfail($id)->delete();

        return Redirect::route('views.clients.index')->withInput()->with([
            'message' => __('Deleted successfully'),
            'type' => 'success'
        ]);
    }
}
