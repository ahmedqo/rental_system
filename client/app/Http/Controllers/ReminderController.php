<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class ReminderController extends Controller
{
    public function index_view()
    {
        return view('reminder.index');
    }

    public function store_view()
    {
        return view('reminder.store');
    }

    public function patch_view($id)
    {
        $data = Reminder::findorfail($id);
        return view('reminder.patch', compact('data'));
    }

    public function search_action(Request $Request)
    {
        $data = Reminder::with('Vehicle')->where('company', Core::company('id'))->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function store_action(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'vehicle' => ['required', 'integer'],

            'consumable_name' => ['required', 'string'],
            'threshold_value' => ['required', 'numeric'],
            'recurrence_amount' => ['required', 'numeric'],
            'unit_of_measurement' => ['required', 'string'],
            'reminder_date' => ['required_unless:unit_of_measurement,mileage', 'date'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        if ($Request->unit_of_measurement === 'mileage') {
            $mileage = Core::company('mileage_per_day');
            $Request->merge([
                'view_issued_at' => Carbon::parse(Carbon::today())->addDays(ceil($Request->recurrence_amount / $mileage)),
                'threshold_value' => $Request->threshold_value / $mileage
            ]);
        } else {
            $time = Core::timesList($Request->unit_of_measurement) * $Request->recurrence_amount;
            $date = Carbon::parse($Request->reminder_date);
            while ($date < Carbon::today()) $date->addDays($time);
            $Request->merge([
                'view_issued_at' =>  $date,
            ]);
        }

        Reminder::create($Request->all());

        return Redirect::back()->withInput()->with([
            'message' => __('Created successfully'),
            'type' => 'success'
        ]);
    }

    public function patch_action(Request $Request, $id)
    {
        $validator = Validator::make($Request->all(), [
            'vehicle' => ['required', 'integer'],

            'consumable_name' => ['required', 'string'],
            'threshold_value' => ['required', 'numeric'],
            'recurrence_amount' => ['required', 'numeric'],
            'unit_of_measurement' => ['required', 'string'],
            'reminder_date' => ['required_unless:unit_of_measurement,mileage', 'date'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        if ($Request->unit_of_measurement === 'mileage') {
            $mileage = Core::company('mileage_per_day');
            $Request->merge([
                'view_issued_at' => Carbon::parse(Carbon::today())->addDays(ceil($Request->recurrence_amount / $mileage)),
                'threshold_value' => $Request->threshold_value / $mileage
            ]);
        } else {
            $time = Core::timesList($Request->unit_of_measurement) * $Request->recurrence_amount;
            $date = Carbon::parse($Request->reminder_date);
            while ($date < Carbon::today()) $date->addDays($time);
            $Request->merge([
                'view_issued_at' =>  $date,
            ]);
        }

        $Reminder = Reminder::findorfail($id);
        $Reminder->update($Request->all());

        return Redirect::back()->withInput()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }

    public function clear_action($id)
    {
        Reminder::findorfail($id)->delete();

        return Redirect::route('views.reminders.index')->withInput()->with([
            'message' => __('Deleted successfully'),
            'type' => 'success'
        ]);
    }
}
