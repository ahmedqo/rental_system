<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Functions\Mail as Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Providers\RouteServiceProvider;

class AuthController extends Controller
{
    public function login_view()
    {
        return view('auth.login');
    }

    public function blank_view()
    {
        return view('auth.blank');
    }

    public function reset_view($token)
    {
        return view('auth.reset', compact('token'));
    }

    public function login_action(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        $credentials = $Request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return Redirect::to(RouteServiceProvider::AUTHS);
        }

        return Redirect::back()->withInput()->with([
            'message' => __('Invalid login details'),
            'type' => 'error'
        ]);
    }

    public function blank_action(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        if (!Mailer::reset($Request->email)) {
            return Redirect::back()->withInput()->with([
                'message' => __('The user does not exist'),
                'type' => 'error'
            ]);
        }

        return Redirect::back()->with([
            'message' => __('Please check your email for password reset instructions'),
            'type' => 'success'
        ]);
    }

    public function reset_action(Request $Request, $token)
    {
        $validator = Validator::make($Request->all(), [
            'new_password' => ['required', 'string'],
            'confirm_password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        $row = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$row) {
            return Redirect::back()->withInput()->with([
                'message' => __('The link is invalid'),
                'type' => 'error'
            ]);
        }

        $user = User::where('email', $row->email)->first();

        if (!$user) {
            return Redirect::back()->withInput()->with([
                'message' => __('The user does not exist'),
                'type' => 'error'
            ]);
        }

        if ($Request->new_password != $Request->confirm_password) {
            return Redirect::back()->withInput()->with([
                'message' => __('Confirm password missmatch'),
                'type' => 'error'
            ]);
        }

        DB::table('password_reset_tokens')->where('token', $token)->delete();
        $user->password = Hash::make($Request->new_password);
        $user->save();

        return Redirect::route("views.login.index")->with([
            'message' => __('Changed successfully'),
            'type' => 'success'
        ]);
    }

    public function close_action()
    {
        Auth::logout();

        return Redirect::route("views.login.index")->with([
            'message' => __('Logout successfully'),
            'type' => 'success'
        ]);
    }
}
