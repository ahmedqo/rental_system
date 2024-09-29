<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Models\Company;
use App\Models\User;
use App\Functions\Mail as Mailer;
use App\Models\Agency;
use App\Models\Charge;
use App\Models\Client;
use App\Models\Reservation;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index_view()
    {
        return view('company.index');
    }

    public function store_view()
    {
        return view('company.store');
    }

    public function patch_view($id)
    {
        $data = Company::with('Image', 'Representative')->findorfail($id);
        return view('company.patch', compact('data'));
    }

    public function scene_view($id)
    {
        $data = Company::findorfail($id);

        [$startDate, $endDate, $columns] = Core::getDates();

        $vals = Reservation::where('reservations.company', $id)->whereBetween('reservations.created_at', [$startDate, $endDate])
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

        $vals->charges = Charge::where('company', $id)->whereBetween('created_at', [$startDate, $endDate])->sum('cost');

        $vals->ended = Reservation::where('company', $id)->where('status', '!=', 'completed')
            ->where('dropoff_date', '<', now())->count();

        return view('company.scene', compact('data', 'vals'));
    }

    public function popular_action($id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Vehicle', 'Payment')
            ->where('company', $id)
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
                $mileage = $period *  $group->first()->mileage_per_day;
                return compact('vehicle', 'paid', 'rest', 'period', 'mileage');
            })
            ->sortByDesc('paid')
            ->take(10)
            ->toArray();

        return response()->json(['data' => array_values($data)]);
    }

    public function chart_action($id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = [
            'charges' => array_slice($columns, 0),
            'payments' => array_slice($columns, 0),
            'creances' => array_slice($columns, 0),
        ];

        Reservation::with('Payment')->where('company', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()->groupBy(function ($model) {
                return Core::groupKey($model);
            })->each(function ($group, $key) use (&$data) {
                $group->each(function ($carry) use (&$data, &$key) {
                    $data['creances'][$key] += $carry->Payment->rest;
                    $data['payments'][$key] += $carry->Payment->paid;
                });
            });


        Charge::where('company', $id)->whereBetween('created_at', [$startDate, $endDate])
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
        $data = Company::with('Image', 'Representative')->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function search_reservations_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Vehicle', 'Client', 'SClient', 'Agency')->where('company', $id)->where('status', '!=', 'completed')->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function filter_reservations_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Vehicle', 'Client', 'SClient', 'Agency')->where('company', $id)->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function search_payments_action(Request $Request, $id)
    {
        [$startDate, $endDate, $columns] = Core::getDates();

        $data = Reservation::with('Client', 'SClient', 'Agency', 'Payment')->where('company', $id)->where('status', '!=', 'completed')->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            return collect([
                'reference' => $carry->reference,
                'vehicle' => $carry->Vehicle,
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

        $data = Reservation::with('Client', 'SClient', 'Agency', 'Payment')->where('company', $id)->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            return collect([
                'reference' => $carry->reference,
                'vehicle' => $carry->Vehicle,
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

        $data = Reservation::with('Client', 'SClient', 'Agency', 'Recovery')->where('company', $id)->where('status', '!=', 'completed')->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            return collect([
                'reference' => $carry->reference,
                'vehicle' => $carry->Vehicle,
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

        $data = Reservation::with('Client', 'SClient', 'Agency', 'Recovery')->where('company', $id)->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            return collect([
                'reference' => $carry->reference,
                'vehicle' => $carry->Vehicle,
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

        $data = Charge::with('Vehicle')->where('company', $id)
            ->whereBetween('created_at', [$startDate, $endDate]);
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function store_action(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'company_logo' => ['required', 'image'],
            'name' => ['required', 'string', 'unique:companies,name'],
            'email' => ['required', 'email', 'unique:companies,email'],
            'phone' => ['required', 'string'],

            'city' => ['required', 'string'],
            'zipcode' => ['required', 'string'],
            'address' => ['required', 'string'],

            'ice_number' => ['required', 'string'],
            'license_number' => ['required', 'string'],

            'representative_email' => ['required', 'email', 'unique:users,email'],
            'representative_phone' => ['required', 'string', 'unique:users,phone'],
            'representative_last_name' => ['required', 'string'],
            'representative_first_name' => ['required', 'string'],

            'mileage_per_day' =>  ['required', 'numeric'],
            'status' =>  ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        $Company = Company::create([
            'mileage_per_day' => $Request->mileage_per_day,
            'status' => $Request->status,

            'name' => strtolower($Request->name),
            'email' => $Request->email,
            'phone' => $Request->phone,

            'city' => $Request->city,
            'zipcode' => $Request->zipcode,
            'address' => $Request->address,

            'ice_number' => $Request->ice_number,
            'license_number' => $Request->license_number,
        ]);

        $file =  $Request->file('company_logo');
        Http::attach(
            'company_logo',
            file_get_contents($file),
            $file->getClientOriginalName()
        )->post(Core::route($Company->id), [
            'token' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

        $User =  User::create([
            'company' => $Company->id,

            'last_name' => strtolower($Request->representative_last_name),
            'first_name' => strtolower($Request->representative_first_name),

            'email' => $Request->representative_email,
            'phone' => $Request->representative_phone,

            'password' => Hash::make(Str::random(20)),
        ]);

        $User->Setting()->create([
            'language' => 'fr',
            'currency' => 'MAD',
            'report_frequency' => 'week',
            'date_format' => 'YYYY-MM-DD',
            'theme_color' => 'ocean tide',
        ]);

        Mailer::reset($Request->representative_email);

        return Redirect::back()->with([
            'message' => __('Created successfully'),
            'type' => 'success'
        ]);
    }

    public function patch_action(Request $Request, $id)
    {
        $Company = Company::findorfail($id);
        $Representative = $Company->Representative;
        $validator = Validator::make($Request->all(), [
            'name' => ['required', 'string', 'unique:companies,name,' . $id],
            'email' => ['required', 'email', 'unique:companies,email,' . $id],
            'phone' => ['required', 'string'],

            'city' => ['required', 'string'],
            'zipcode' => ['required', 'string'],
            'address' => ['required', 'string'],

            'ice_number' => ['required', 'string'],
            'license_number' => ['required', 'string'],

            'representative_email' => ['required', 'email', 'unique:users,email,' . $Representative->id],
            'representative_phone' => ['required', 'string', 'unique:users,phone,' . $Representative->id],
            'representative_last_name' => ['required', 'string'],
            'representative_first_name' => ['required', 'string'],

            'mileage_per_day' =>  ['required', 'numeric'],
            'status' =>  ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        $Company->update([
            'mileage_per_day' => $Request->mileage_per_day,
            'status' => $Request->status,

            'name' => strtolower($Request->name),
            'email' => $Request->email,
            'phone' => $Request->phone,

            'city' => $Request->city,
            'zipcode' => $Request->zipcode,
            'address' => $Request->address,

            'ice_number' => $Request->ice_number,
            'license_number' => $Request->license_number,
        ]);

        $Representative->update([
            'first_name' => strtolower($Request->representative_first_name),
            'last_name' => strtolower($Request->representative_last_name),

            'email' => $Request->representative_email,
            'phone' => $Request->representative_phone,
        ]);

        if ($Request->hasFile('company_logo')) {
            $file =  $Request->file('company_logo');
            Http::attach(
                'company_logo',
                file_get_contents($file),
                $file->getClientOriginalName()
            )->post(Core::route($Company->id), [
                'token' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            ]);
        }

        return Redirect::back()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }

    public function clear_action($id)
    {
        Http::post(Core::route($id), [
            'token' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'clear' => true
        ]);

        return Redirect::route('views.companies.index')->with([
            'message' => __('Deleted successfully'),
            'type' => 'success'
        ]);
    }
}
