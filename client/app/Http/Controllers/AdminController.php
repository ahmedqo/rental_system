<?php

namespace App\Http\Controllers;

use App\Functions\Mail as Mailer;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index_view()
    {
        return view('user.index');
    }

    public function store_view()
    {
        return view('user.store');
    }

    public function patch_view($id)
    {
        $data = Admin::findorfail($id);
        return view('user.patch', compact('data'));
    }

    public function search_action(Request $Request)
    {
        $data = Admin::orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function store_action(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:admins,email'],
            'phone' => ['required', 'string', 'unique:admins,phone'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        $Admin = Admin::create($Request->merge([
            'password' =>  Hash::make(Str::random(20)),
            'first_name' => strtolower($Request->first_name),
            'last_name' => strtolower($Request->last_name),
        ])->all());

        $Admin->Setting()->create([
            'language' => 'fr',
            'currency' => 'MAD',
            'report_frequency' => 'week',
            'date_format' => 'YYYY-MM-DD',
            'theme_color' => 'ocean tide',
        ]);

        Mailer::reset($Request->email);

        return Redirect::back()->withInput()->with([
            'message' => __('Created successfully'),
            'type' => 'success'
        ]);
    }

    public function patch_action(Request $Request, $id)
    {
        $validator = Validator::make($Request->all(), [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:admins,email,' . $id],
            'phone' => ['required', 'string', 'unique:admins,phone,' . $id],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        Admin::findorfail($id)->update($Request->merge([
            'first_name' => strtolower($Request->first_name),
            'last_name' => strtolower($Request->last_name)
        ])->all());

        return Redirect::back()->withInput()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }

    public function clear_action($id)
    {
        Admin::findorfail($id)->delete();

        return Redirect::route('views.users.index')->withInput()->with([
            'message' => __('Deleted successfully'),
            'type' => 'success'
        ]);
    }
}
