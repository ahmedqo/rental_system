<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Models\Charge;
use App\Models\Reminder;
use App\Models\Vehicle;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    public function index_view()
    {
        return view('vehicle.index');
    }

    public function store_view()
    {
        return view('vehicle.store');
    }

    public function patch_view($id)
    {
        $data = Vehicle::findorfail($id);
        return view('vehicle.patch', compact('data'));
    }

    public function scene_view($id)
    {
        $data = Vehicle::with('Owner')->findorfail($id);

        [$startDate, $endDate, $columns] = Core::getDates();

        $vals = Reservation::where('reservations.vehicle', $id)
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

        $vals->charges = Charge::where('vehicle', $id)->whereBetween('created_at', [$startDate, $endDate])->sum('cost');

        $today = Carbon::today();
        $reminders = Reminder::where('vehicle', $id)
            ->whereRaw("? BETWEEN DATE_SUB(view_issued_at, INTERVAL threshold_value HOUR) AND view_issued_at", [$today])
            ->get();

        $vals->ended = Reservation::where('vehicle', $id)->where('status', '!=', 'completed')
            ->where('dropoff_date', '<', now())->count();

        return view('vehicle.scene', compact('data', 'vals', 'reminders'));
    }

    public function chart_action($id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = [
            'charges' => array_slice($columns, 0),
            'payments' => array_slice($columns, 0),
            'creances' => array_slice($columns, 0),
        ];

        Reservation::with('Payment')->where('vehicle', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()->groupBy(function ($model) {
                return Core::groupKey($model);
            })->each(function ($group, $key) use (&$data) {
                $group->each(function ($carry) use (&$data, &$key) {
                    $data['creances'][$key] += $carry->Payment->rest;
                    $data['payments'][$key] += $carry->Payment->paid;
                });
            });


        Charge::where('vehicle', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()->groupBy(function ($model) {
                return Core::groupKey($model);
            })->map(function ($group) {
                return $group->sum(function ($carry) {
                    return $carry->cost;
                });
            })->each(function ($item, $key) use (&$data) {
                $data['charges'][$key] = $item;
            });

        return response()->json([
            'data' => [
                'keys' => array_keys($columns),
                'charges' => array_values($data['charges']),
                'payments' => array_values($data['payments']),
                'creances' => array_values($data['creances']),
            ]
        ]);
    }

    public function search_action(Request $Request)
    {
        $data = Vehicle::with('Owner')->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function search_reservations_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Client', 'SClient', 'Agency')->where('vehicle', $id)->where('status', '!=', 'completed')->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function filter_reservations_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Client', 'SClient', 'Agency')->where('vehicle', $id)->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function search_payments_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Client', 'SClient', 'Agency', 'Payment')->where('vehicle', $id)->where('status', '!=', 'completed')->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            return collect([
                'reference' => $carry->reference,
                'client' => $carry->Client,
                'sclient' => $carry->SClient,
                'agency' => $carry->Agency,
            ])->merge($carry->Payment);
        });
        return response()->json($data);
    }

    public function filter_payments_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Client', 'SClient', 'Agency', 'Payment')->where('vehicle', $id)->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            return collect([
                'reference' => $carry->reference,
                'client' => $carry->Client,
                'sclient' => $carry->SClient,
                'agency' => $carry->Agency,
            ])->merge($carry->Payment);
        });
        return response()->json($data);
    }

    public function search_recoveries_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Client', 'SClient', 'Agency', 'Recovery')->where('vehicle', $id)->where('status', '!=', 'completed')->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            return collect([
                'reference' => $carry->reference,
                'client' => $carry->Client,
                'sclient' => $carry->SClient,
                'agency' => $carry->Agency,
            ])->merge($carry->Recovery);
        });
        return response()->json($data);
    }

    public function filter_recoveries_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Client', 'SClient', 'Agency', 'Recovery')->where('vehicle', $id)->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            return collect([
                'reference' => $carry->reference,
                'client' => $carry->Client,
                'sclient' => $carry->SClient,
                'agency' => $carry->Agency,
            ])->merge($carry->Recovery);
        });
        return response()->json($data);
    }

    public function search_charges_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Charge::where('vehicle', $id)
            ->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function get_info_action($id)
    {
        $Reservation = Reservation::with('Recovery')->where('vehicle', $id)->orderBy('id', 'DESC')->first();
        $Recovery = $Reservation ? $Reservation->Recovery : null;
        return response()->json(['data' => [
            'mileage' => $Recovery ? $Recovery->mileage : null,
            'fuel_level' => $Recovery ? $Recovery->fuel_level : null
        ]]);
    }

    public function store_action(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'registration_type' => ['required', 'string'],
            'brand' => ['required', 'string'],
            'model' => ['required', 'string'],
            'year' => ['required', 'numeric'],
            'daily_rate' => ['required', 'numeric'],

            'passenger_capacity' => ['required', 'integer'],
            'mileage' => ['required', 'numeric'],
            'number_of_doors' => ['required', 'integer'],
            'cargo_capacity' => ['required', 'integer'],
            'transmission_type' => ['required', 'string'],
            'fuel_type' => ['required', 'string'],

            'registration_date' => ['required', 'date'],
            'horsepower' => ['required', 'string'],
            'horsepower_tax' => ['required', 'numeric'],
            'insurance_company' => ['required', 'string'],
            'insurance_issued_at' => ['required', 'date'],
            'insurance_cost' => ['required', 'numeric'],

            'registration_ww_part_1' => ['required_if:registration_type,WW', 'string'],
            'registration_ww_part_2' => ['required_if:registration_type,WW', 'string'],
            'registration_vehicle_part_1' => ['required_if:registration_type,vehicle', 'string'],
            'registration_vehicle_part_2' => ['required_if:registration_type,vehicle', 'string'],
            'registration_vehicle_part_3' => ['required_if:registration_type,vehicle', 'string'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        Vehicle::create($Request->merge([
            'registration_number' => $Request->registration_type == 'WW' ? ($Request->registration_ww_part_1 . '-' . $Request->registration_ww_part_2) : ($Request->registration_vehicle_part_1 . '-' . $Request->registration_vehicle_part_2 . '-' . $Request->registration_vehicle_part_3)
        ])->all());

        return Redirect::back()->withInput()->with([
            'message' => __('Created successfully'),
            'type' => 'success'
        ]);
    }

    public function patch_action(Request $Request, $id)
    {
        $validator = Validator::make($Request->all(), [
            'registration_type' => ['required', 'string'],
            'brand' => ['required', 'string'],
            'model' => ['required', 'string'],
            'year' => ['required', 'numeric'],
            'daily_rate' => ['required', 'numeric'],

            'passenger_capacity' => ['required', 'integer'],
            'mileage' => ['required', 'numeric'],
            'number_of_doors' => ['required', 'integer'],
            'cargo_capacity' => ['required', 'integer'],
            'transmission_type' => ['required', 'string'],
            'fuel_type' => ['required', 'string'],

            'registration_date' => ['required', 'date'],
            'horsepower' => ['required', 'string'],
            'horsepower_tax' => ['required', 'numeric'],
            'insurance_company' => ['required', 'string'],
            'insurance_issued_at' => ['required', 'date'],
            'insurance_cost' => ['required', 'numeric'],

            'registration_ww_part_1' => ['required_if:registration_type,WW', 'string'],
            'registration_ww_part_2' => ['required_if:registration_type,WW', 'string'],
            'registration_vehicle_part_1' => ['required_if:registration_type,vehicle', 'string'],
            'registration_vehicle_part_2' => ['required_if:registration_type,vehicle', 'string'],
            'registration_vehicle_part_3' => ['required_if:registration_type,vehicle', 'string'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        $Vehicle = Vehicle::findorfail($id);

        $Vehicle->update($Request->merge([
            'registration_number' => $Request->registration_type == 'WW' ? ($Request->registration_ww_part_1 . '-' . $Request->registration_ww_part_2) : ($Request->registration_vehicle_part_1 . '-' . $Request->registration_vehicle_part_2 . '-' . $Request->registration_vehicle_part_3)
        ])->all());

        return Redirect::back()->withInput()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }

    public function clear_action($id)
    {
        Vehicle::findorfail($id)->delete();

        return Redirect::route('views.vehicles.index')->withInput()->with([
            'message' => __('Deleted successfully'),
            'type' => 'success'
        ]);
    }
}
