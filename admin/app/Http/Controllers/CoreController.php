<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Models\Charge;
use App\Models\Company;
use App\Models\Reservation;

class CoreController extends Controller
{
    public function index_view()
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $vals = Reservation::whereBetween('reservations.created_at', [$startDate, $endDate])
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

        $vals->charges = Charge::whereBetween('created_at', [$startDate, $endDate])->sum('cost');
        $vals->companies = Company::whereBetween('created_at', [$startDate, $endDate])->count();
        return view('core.index', compact('vals'));
    }

    public function popular_action()
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Owner', 'Vehicle', 'Payment')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy('vehicle')
            ->map(function ($group) {
                $Vehicle = $group->first()->Vehicle;
                $Owner = $group->first()->Owner;
                $vehicle = ucfirst(__($Vehicle->brand)) . ' ' . ucfirst(__($Vehicle->model)) . ' '
                    . $Vehicle->year . ' (' . strtoupper($Vehicle->registration_number) . ')';

                $owner = $Owner ? ucfirst($Owner->name) : 'N/A';
                $paid = $group->sum(function ($reservation) {
                    return $reservation->Payment->paid;
                });

                $rest = $group->sum(function ($reservation) {
                    return $reservation->Payment->rest;
                });

                $period = $group->sum('rental_period_days');
                $mileage = $period * ($Owner ? $Owner->mileage_per_day : 100);
                return compact('owner', 'vehicle', 'paid', 'rest', 'period', 'mileage');
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

        Reservation::with('Payment')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()->groupBy(function ($model) {
                return Core::groupKey($model);
            })->each(function ($group, $key) use (&$data) {
                $group->each(function ($carry) use (&$data, &$key) {
                    $data['creances'][$key] += $carry->Payment->rest;
                    $data['payments'][$key] += $carry->Payment->paid;
                });
            });


        Charge::whereBetween('created_at', [$startDate, $endDate])
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
