<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Models\Charge;
use App\Models\Company;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CoreController extends Controller
{
    public function index_view()
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $vals = Reservation::where('reservations.company', Core::company('id'))->whereBetween('reservations.created_at', [$startDate, $endDate])
            ->join('payments', 'reservations.id', '=', 'payments.reservation')
            ->selectRaw('
                COUNT(DISTINCT reservations.id) as count,
                SUM(reservations.rental_period_days) as period,
                SUM(payments.total) as total,
                SUM(payments.paid) as paid,
                SUM(payments.rest) as rest
            ')->first() ?? (object) [
                'count' => 0,
                'period' => 0,
                'total' => 0,
                'paid' => 0,
                'rest' => 0
            ];

        $vals->charges = Charge::where('company', Core::company('id'))->whereBetween('created_at', [$startDate, $endDate])->sum('cost');
        return view('core.index', compact('vals'));
    }

    public function notify_view()
    {
        return view('core.notify');
    }

    public function notify_action()
    {
        $id = Auth::id();

        $data = Notification::where('company', Core::company('id'))->limit(5)
            ->orderBy('id', 'DESC')->get()->map(function ($Carry) use ($id) {
                $Carry->content =  $Carry->content;
                $Carry->ring = !str_contains($Carry->view, (string) $id);
                return $Carry;
            });

        return response()->json($data);
    }

    public function read_action()
    {
        $id = Auth::id();
        Notification::where('company', Core::company('id'))->where(function ($Query) use ($id) {
            $Query->whereNull('view')
                ->orWhereRaw('view NOT LIKE ?', ['%' . $id . '%']);
        })->each(function ($Carry) use ($id) {
            $Carry->update([
                'view' => $Carry->view ? $Carry->view . ',' . $id : (string) $id
            ]);
        });
    }

    public function popular_action()
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Vehicle', 'Payment')
            ->where('company', Core::company('id'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy('vehicle')
            ->map(function ($group) {
                $Vehicle = $group->first()->Vehicle;
                $vehicle = ucfirst(__($Vehicle->brand)) . ' ' . ucfirst(__($Vehicle->model)) . ' '
                    . $Vehicle->year . ' (' . strtoupper($Vehicle->registration_number) . ')';

                $paid = $group->sum(function ($reservation) {
                    return $reservation->Payment->paid;
                });

                $rest = $group->sum(function ($reservation) {
                    return $reservation->Payment->rest;
                });

                $period = $group->sum('rental_period_days');
                $mileage = $period * Core::company('mileage_per_day');
                return compact('vehicle', 'paid', 'rest', 'period', 'mileage');
            })
            ->sortByDesc('paid')
            ->take(10)
            ->toArray();

        return response()->json(['data' => array_values($data)]);
    }

    public function chart_action()
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = [
            'charges' => array_slice($columns, 0),
            'payments' => array_slice($columns, 0),
            'creances' => array_slice($columns, 0),
        ];

        Payment::where('company', Core::company('id'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()->groupBy(function ($model) {
                return Core::groupKey($model);
            })->each(function ($group, $key) use (&$data) {
                $group->each(function ($carry) use (&$data, &$key) {
                    $data['creances'][$key] += $carry->rest;
                });
            });

        Payment::where('company', Core::company('id'))
            ->whereBetween('updated_at', [$startDate, $endDate])
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

        Charge::where('company', Core::company('id'))->whereBetween('created_at', [$startDate, $endDate])
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
}
