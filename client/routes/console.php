<?php

use App\Functions\Core;
use App\Models\Reminder;
use App\Models\Reservation;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('notification:update', function () {
    $today = Carbon::today();
    $tomorrow = Carbon::tomorrow();

    Vehicle::where('due_period', '>', 0)->whereDay('loan_issued_at', $tomorrow->day)->get()->map(function ($Carry) use (&$tomorrow) {
        $text = '<div class="flex flex-wrap items-center gap-4 p-4"><span class="w-10 h-10 rounded-full bg-x-prime text-x-white flex items-center justify-center"><svg class="pointer-events-none w-6 h-6" viewBox="0 -960 960 960" fill="currentColor"><path d="M153-266v-274h121v274H153Zm267 0v-274h120v274H420ZM28-81v-136h904v136H28Zm658-185v-274h121v274H686ZM28-590v-146l452-228 452 228v146H28Z"/></svg></span><span class="w-0 flex-1">The monthly instalment of ":money" for ":vehicle" is due on ":date"</span></div>';
        $vars =  json_encode([
            'money' => Core::formatNumber($Carry->monthly_installment),
            'vehicle' => ucfirst(__($Carry->brand)) . ' ' . ucfirst(__($Carry->model)) . ' ' . $Carry->year . ' (' . strtoupper($Carry->registration_number) . ')',
            'date' => $tomorrow,
        ]);
        $exists = $Carry->Notifications()->where('text', $text)
            ->where('vars', $vars)->exists();
        if (!$exists)  $Carry->Notifications()->create([
            'company' => $Carry->company,
            'text' => $text,
            'vars' => $vars,
        ]);
    });

    Vehicle::where(DB::raw('CAST(year AS SIGNED)'), '<', $today->year - 4)->get()->map(function ($Carry) {
        $text = '<a href=":route" class="flex flex-wrap items-center gap-4 p-4 hover:bg-x-light"><span class="w-10 h-10 rounded-full bg-x-prime text-x-white flex items-center justify-center"><svg class="pointer-events-none w-6 h-6" viewBox="0 -960 960 960" fill="currentColor"><path d="M614.5-284q25.5 0 43.5-18.38t18-43.5q0-25.12-18.12-43.62Q639.75-408 615-408q-26 0-44 18.38t-18 43.5q0 25.12 18 43.62 18 18.5 43.5 18.5ZM265-284q26 0 44-18.38t18-43.5q0-25.12-18-43.62-18-18.5-43.5-18.5T222-389.62q-18 18.38-18 43.5t18.13 43.62Q240.25-284 265-284Zm461-242q-83 0-141.5-58.5T526-726q0-84 59-142t141-58q83 0 141.5 58.5T926-726q0 83-58.5 141.5T726-526Zm-34-177h68v-160h-68v160Zm34.5 115q14.5 0 24-9t9.5-23.5q0-14.5-9.5-25t-24-10.5q-14.5 0-24.5 10.5t-10 25q0 14.5 10 23.5t24.5 9ZM115.81-41q-32.26 0-54.03-21.56Q40-84.13 40-116v-331.43L127-695q11-29 35.8-46.5Q187.6-759 218-759h231q-4 32-.5 65t13.5 64H241l-36 105h325q39 38 89.36 58 50.35 20 104.64 20 30.65 0 59.83-6Q813-459 840-472v355.83q0 32.21-21.78 53.69Q796.45-41 764.19-41H753.3q-32.3 0-54.8-20.7T676-113v-8H204v8q0 30.6-22.5 51.3Q159-41 126.7-41h-10.89Z"/></svg></span><span class="w-0 flex-1">":vehicle" has been in service since ":year" exceeding a duration of 5 years</span></a>';
        $vars =  json_encode([
            'route' => route('views.vehicles.patch', $Carry->id),
            'vehicle' => ucfirst(__($Carry->brand)) . ' ' . ucfirst(__($Carry->model)) . ' ' . $Carry->year . ' (' . strtoupper($Carry->registration_number) . ')',
            'year' => $Carry->year,
        ]);
        $exists = $Carry->Notifications()->where('text', $text)
            ->where('vars', $vars)->exists();
        if (!$exists)  $Carry->Notifications()->create([
            'company' => $Carry->company,
            'text' => $text,
            'vars' => $vars,
        ]);
    });

    Reminder::with('Vehicle')
        ->whereRaw("? BETWEEN DATE_SUB(view_issued_at, INTERVAL threshold_value HOUR) AND view_issued_at", [$today])
        ->get()->map(function ($Carry) {
            $text = '<div class="flex flex-wrap items-center gap-4 p-4"><span class="w-10 h-10 rounded-full bg-x-prime text-x-white flex items-center justify-center"><svg class="pointer-events-none w-6 h-6" viewBox="0 -960 960 960" fill="currentColor"><path d="M739-423v-114h210v114H739Zm80 299L651-249l69-92 167 125-68 92Zm-99-495-69-92 168-125 68 92-167 125ZM129-161v-161h-6q-48-6-80-42.5T11-450v-60q0-52 37.5-90t90.5-38h131l247-149v614L270-322h-5v161H129Zm444-149v-340q42 28 67 73t25 97q0 52-25 97t-67 73Z" /></svg></span><span class="w-0 flex-1">":consumable" on ":vehicle" at ":date"</span></div>';
            $vars =  json_encode([
                'consumable' => ucfirst(__($Carry->consumable_name)),
                'vehicle' => ucfirst(__($Carry->Vehicle->brand)) . ' ' . ucfirst(__($Carry->Vehicle->model)) . ' ' . $Carry->Vehicle->year . ' (' . strtoupper($Carry->Vehicle->registration_number) . ')',
                'date' => $Carry->view_issued_at,
            ]);
            $exists = $Carry->Notifications()->where('text', $text)
                ->where('vars', $vars)->exists();
            if (!$exists)  $Carry->Notifications()->create([
                'company' => $Carry->company,
                'text' => $text,
                'vars' => $vars,
            ]);
        });

    Reminder::whereDate('view_issued_at', '<', $today)->get()->map(function ($item) {
        if ($item->unit_of_measurement === 'mileage') {
            $mileage = $item->Owner->mileage_per_day;
            $item->update([
                'view_issued_at' => Carbon::parse(Carbon::today())->addDays(ceil($item->recurrence_amount / $mileage)),
                'threshold_value' => $item->threshold_value / $mileage
            ]);
        } else {
            $time = Core::timesList($item->unit_of_measurement) * $item->recurrence_amount;
            $date = Carbon::parse($item->reminder_date);
            while ($date < Carbon::today()) $date->addDays($time);
            $item->update([
                'view_issued_at' =>  $date,
            ]);
        }
    });

    Reservation::with(['Recovery' => function ($query) {
        $query->select('id', 'reservation');
    }])
        ->where(function ($query) use ($today) {
            $query->whereBetween('dropoff_date', [
                // Carbon::parse($today)->subDay()->startOfDay(),
                // Carbon::parse($today)->endOfDay()
                Carbon::parse($today)->endOfDay(),
                Carbon::parse($today)->addDay()->endOfDay()
            ])
                ->orWhere(function ($sub) {
                    $sub->where('status', '!=', 'completed')
                        ->where('dropoff_date', '<', now());
                });
        })->get()->map(function ($Carry) {
            $text = '<a href=":route" class="flex flex-wrap items-center gap-4 p-4 hover:bg-x-light"><span class="w-10 h-10 rounded-full bg-x-prime text-x-white flex items-center justify-center"><svg class="pointer-events-none w-6 h-6" viewBox="0 -960 960 960" fill="currentColor">' . ($Carry->dropoff_date < now() ? '<path d="M480-40q-26 0-50.94-10.74Q404.12-61.48 384-80L80-384q-18.52-20.12-29.26-45.06Q40-454 40-480q0-26 10.59-51.12Q61.17-556.24 80-576l304-304q20.12-20.48 45.06-30.24Q454-920 480-920q26 0 51.12 9.91Q556.24-900.17 576-880l304 304q20.17 19.76 30.09 44.88Q920-506 920-480q0 26-9.76 50.94Q900.48-404.12 880-384L576-80q-19.76 18.83-44.88 29.41Q506-40 480-40Zm-60-382h120v-250H420v250Zm60 160q25.38 0 42.69-17.81Q540-297.63 540-322q0-25.38-17.31-42.69T480-382q-25.37 0-42.69 17.31Q420-347.38 420-322q0 24.37 17.31 42.19Q454.63-262 480-262Z"/>' : '<path d="M480-35q-83 0-157-32t-129.5-87Q138-209 106-283T74-441q0-84 32-157.5t87.5-129Q249-783 323-815t157-32q84 0 158 32t129 87.5q55 55.5 87 129T886-441q0 84-32 158t-87 129q-55 55-129 87T480-35Zm102-225 76-76-125-124v-182H427v228l155 154ZM204-922l75 74L73-641l-74-75 205-206Zm552 0 206 206-74 75-207-207 75-74Z"/>') . '</svg></span><span class="w-0 flex-1">Reservation ":reference" ' . ($Carry->dropoff_date < now() ? 'ended at' : 'will end at') . ' ":date"</span></a>';
            $vars = json_encode([
                'route' => route('views.recoveries.patch', $Carry->Recovery->id),
                'reference' => $Carry->reference,
                'date' => $Carry->dropoff_date,
            ]);
            $exists = $Carry->Notifications()->where('text', $text)
                ->where('vars', $vars)->exists();
            if (!$exists)  $Carry->Notifications()->create([
                'company' => $Carry->company,
                'text' =>  $text,
                'vars' => $vars,
            ]);
        });
})->purpose('update notifications dates');
