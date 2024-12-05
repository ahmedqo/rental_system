<?php

use App\Functions\Core;
use App\Models\Reminder;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

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

Artisan::command('reminder:update', function () {
    $today = Carbon::today();
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
})->purpose('update reminders dates');


Artisan::command('notification:update', function () {
    $today = Carbon::today();

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
                ->orWhere(function ($sub) use ($today) {
                    $sub->where('status', '!=', 'completed')
                        ->where('dropoff_date', '<', $today);
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
