<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function password_view()
    {
        return view('profile.password');
    }

    public function profile_view()
    {
        $data = Auth::user();
        return view('profile.patch', compact('data'));
    }

    public function password_action(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string'],
            'confirm_password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        if (!Hash::check($Request->old_password, Auth::user()->password)) {
            return Redirect::back()->withInput()->with([
                'message' => __('Old password missmatch'),
                'type' => 'error'
            ]);
        }

        if ($Request->new_password != $Request->confirm_password) {
            return Redirect::back()->withInput()->with([
                'message' => __('Confirm password missmatch'),
                'type' => 'error'
            ]);
        }

        $password = Hash::make($Request->new_password);
        User::find(Auth::user()->id)->update([
            "password" => $password
        ]);

        return Redirect::back()->with([
            'message' => __('Changed successfully'),
            'type' => 'success'
        ]);
    }

    public function profile_action(Request $Request)
    {
        $data = Auth::user();

        $validator = Validator::make($Request->all(), [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,' . $data->id],
            'phone' => ['required', 'string', 'unique:users,phone,' . $data->id],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        User::findorfail($data->id)->update(
            $Request->merge([
                'first_name' => strtolower($Request->first_name),
                'last_name' => strtolower($Request->last_name)
            ])->all()
        );

        return Redirect::back()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }
}
