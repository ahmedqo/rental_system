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
            $text = '":consumable" on ":vehicle" at ":date"';
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
            $text = 'Reservation ":reference" ' . ($Carry->dropoff_date < now() ? 'ended at' : 'will end at') . ' ":date" <a href=":route" class="text-x-prime underline underline-offset-2 ms-2">view</a>';
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
