<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Models\Charge;
use App\Models\Payment;
use App\Models\Recovery;
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
        $data = Vehicle::findorfail($id);

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
        $vals->ended = Reservation::where('vehicle', $id)->where('status', '!=', 'completed')
            ->where('dropoff_date', '<', now())->count();

        $today = Carbon::today();
        $reminders = Reminder::where('vehicle', $id)
            ->whereRaw("? BETWEEN DATE_SUB(view_issued_at, INTERVAL threshold_value HOUR) AND view_issued_at", [$today])
            ->get();

        return view('vehicle.scene', compact('data', 'vals', 'reminders'));
    }

    public function chart_action($id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = [
            'charges' => array_slice($columns, 0, null, true),
            'payments' => array_slice($columns, 0, null, true),
            'creances' => array_slice($columns, 0, null, true),
        ];

        Payment::with([
            "Reservation" => function ($Query) {
                $Query->select('id', 'vehicle');
            },
        ])->whereHas('Reservation', function ($query) use ($id) {
            $query->where('vehicle', $id);
        })->whereBetween('created_at', [$startDate, $endDate])
            ->get()->groupBy(function ($model) {
                return Core::groupKey($model);
            })->each(function ($group, $key) use (&$data) {
                $group->each(function ($carry) use (&$data, &$key) {
                    $data['creances'][$key] += $carry->rest;
                });
            });

        Payment::with([
            "Reservation" => function ($Query) {
                $Query->select('id', 'vehicle');
            },
        ])->whereHas('Reservation', function ($query) use ($id) {
            $query->where('vehicle', $id);
        })->whereBetween('updated_at', [$startDate, $endDate])
            ->get()->map(function ($carry) {
                return collect(json_decode($carry->logs));
            })->flatten(1)->groupBy(function ($model) {
                $model->date = str_replace('GMT+0100 (GMT+01:00)', '', $model->date);
                return Core::groupKey($model, prop: "date");
            })->each(function ($group, $key) use (&$data) {
                $group->each(function ($carry) use (&$data, &$key) {
                    $data['payments'][$key] += $carry->amount;
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
        $data = Vehicle::where('company', Core::company('id'))->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function search_reservations_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with([
            'Client' =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'SClient'  =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Agency' =>  function ($Query) {
                $Query->select('id', "name");
            }
        ])->where('vehicle', $id)->where('status', '!=', 'completed')->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function filter_reservations_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with([
            'Client' =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'SClient'  =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Agency' =>  function ($Query) {
                $Query->select('id', "name");
            }
        ])->where('vehicle', $id)->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function search_payments_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Payment::with([
            'Reservation',
            'Reservation.Client' =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Reservation.SClient'  =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Reservation.Agency' =>  function ($Query) {
                $Query->select('id', "name");
            }
        ])->whereHas('Reservation', function ($query) use ($id) {
            $query->where('vehicle', $id);
        })->where('status', '!=', 'completed')->whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            $carry->dropoff_date = $carry->Reservation->dropoff_date;
            $carry->reference = $carry->Reservation->reference;
            $carry->sclient = $carry->Reservation->SClient;
            $carry->client = $carry->Reservation->Client;
            $carry->agency = $carry->Reservation->Agency;
            unset($carry->Reservation);
            return $carry;
        });
        return response()->json($data);
    }

    public function filter_payments_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Payment::with([
            'Reservation',
            'Reservation.Client' =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Reservation.SClient'  =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Reservation.Agency' =>  function ($Query) {
                $Query->select('id', "name");
            }
        ])->whereHas('Reservation', function ($query) use ($id) {
            $query->where('vehicle', $id);
        })->whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'DESC');

        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            $carry->dropoff_date = $carry->Reservation->dropoff_date;
            $carry->reference = $carry->Reservation->reference;
            $carry->sclient = $carry->Reservation->SClient;
            $carry->client = $carry->Reservation->Client;
            $carry->agency = $carry->Reservation->Agency;
            unset($carry->Reservation);
            return $carry;
        });
        return response()->json($data);
    }

    public function search_recoveries_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Recovery::with([
            'Reservation',
            'Reservation.Client' =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Reservation.SClient'  =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Reservation.Agency' =>  function ($Query) {
                $Query->select('id', "name");
            }
        ])->whereHas('Reservation', function ($query) use ($id) {
            $query->where('vehicle', $id);
        })->where('status', '!=', 'completed')->whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'DESC');

        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }

        $data = $data->cursorPaginate(50)->through(function ($carry) {
            $carry->dropoff_date = $carry->Reservation->dropoff_date;
            $carry->reference = $carry->Reservation->reference;
            $carry->sclient = $carry->Reservation->SClient;
            $carry->client = $carry->Reservation->Client;
            $carry->agency = $carry->Reservation->Agency;
            unset($carry->Reservation);
            return $carry;
        });
        return response()->json($data);
    }

    public function filter_recoveries_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Recovery::with([
            'Reservation',
            'Reservation.Client' =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Reservation.SClient'  =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Reservation.Agency' =>  function ($Query) {
                $Query->select('id', "name");
            }
        ])->whereHas('Reservation', function ($query) use ($id) {
            $query->where('vehicle', $id);
        })->whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'DESC');

        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            $carry->dropoff_date = $carry->Reservation->dropoff_date;
            $carry->reference = $carry->Reservation->reference;
            $carry->sclient = $carry->Reservation->SClient;
            $carry->client = $carry->Reservation->Client;
            $carry->agency = $carry->Reservation->Agency;
            unset($carry->Reservation);
            return $carry;
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

            'monthly_installment' => ['required_with:loan_amount', 'numeric'],
            'loan_issued_at' => ['required_with:loan_amount', 'date'],

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

        $data = [
            'registration_number' => $Request->registration_type == 'WW' ? ($Request->registration_ww_part_1 . '-' . $Request->registration_ww_part_2) : ($Request->registration_vehicle_part_1 . '-' . $Request->registration_vehicle_part_2 . '-' . $Request->registration_vehicle_part_3),
            'monthly_installment' => null,
            'loan_issued_at' => null,
            'loan_amount' => null,
        ];

        if ($Request->loan_amount && $Request->monthly_installment > 0) {
            $data['monthly_installment'] = (float)$Request->monthly_installment;
            $data['loan_issued_at'] = $Request->loan_issued_at;
            $data['loan_amount'] = (float)$Request->loan_amount;

            $loan_period = ceil($data['loan_amount'] / $data['monthly_installment']);
            $loan_ends = Carbon::parse($data['loan_issued_at'])->addMonths($loan_period);

            $data['due_period'] =  (float) Carbon::now()->diffInMonths($loan_ends, false);
            $data['paid_period'] = max(0, $loan_period - $data['due_period']);

            $data['paid_amount'] = $data['paid_period'] * $data['monthly_installment'];
            $data['due_amount'] = max(0, $data['due_period']) * $data['monthly_installment'];
        }

        Vehicle::create($Request->merge($data)->all());

        return Redirect::back()->with([
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

            'monthly_installment' => ['required_with:loan_amount', 'numeric'],
            'loan_issued_at' => ['required_with:loan_amount', 'date'],

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

        $data = [
            'registration_number' => $Request->registration_type == 'WW' ? ($Request->registration_ww_part_1 . '-' . $Request->registration_ww_part_2) : ($Request->registration_vehicle_part_1 . '-' . $Request->registration_vehicle_part_2 . '-' . $Request->registration_vehicle_part_3),
            'monthly_installment' => null,
            'loan_issued_at' => null,
            'loan_amount' => null,
        ];

        if ($Request->loan_amount && $Request->monthly_installment > 0) {
            $data['monthly_installment'] = (float)$Request->monthly_installment;
            $data['loan_issued_at'] = $Request->loan_issued_at;
            $data['loan_amount'] = (float)$Request->loan_amount;

            $loan_period = ceil($data['loan_amount'] / $data['monthly_installment']);
            $loan_ends = Carbon::parse($data['loan_issued_at'])->addMonths($loan_period);

            $data['due_period'] =  (float) Carbon::now()->diffInMonths($loan_ends, false);
            $data['paid_period'] = max(0, $loan_period - $data['due_period']);

            $data['paid_amount'] = $data['paid_period'] * $data['monthly_installment'];
            $data['due_amount'] = max(0, $data['due_period']) * $data['monthly_installment'];
        }

        $Vehicle->update($Request->merge($data)->all());

        return Redirect::back()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }

    public function clear_action($id)
    {
        Vehicle::findorfail($id)->delete();

        return Redirect::route('views.vehicles.index')->with([
            'message' => __('Deleted successfully'),
            'type' => 'success'
        ]);
    }
}
