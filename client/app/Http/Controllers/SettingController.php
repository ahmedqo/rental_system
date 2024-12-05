<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class SettingController extends Controller
{
    public function patch_view()
    {
        $data = Core::setting();
        return view('setting.patch', compact('data'));
    }

    public function patch_action(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'language' => ['required', 'string'],
            'currency' => ['required', 'string'],
            'date_format' => ['required', 'string'],
            'theme_color' => ['required', 'string'],
            'report_frequency' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        $Setting = Core::setting();
        $Setting->update($Request->all());

        return Redirect::back()->withInput()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }
}
