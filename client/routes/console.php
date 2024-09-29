<?php

use App\Functions\Core;
use App\Models\Reminder;
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
