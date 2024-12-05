<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Models\Company;
use App\Models\User;
use App\Functions\Mail as Mailer;
use App\Models\Image;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function store_view()
    {
        return view('company.store');
    }

    public function patch_view()
    {
        $data = Core::company();
        return view('company.patch', compact('data'));
    }

    public function store_action(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'company_logo' => ['required', 'image'],
            'mileage_per_day' =>  ['required', 'numeric'],
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
            'last_name' => ['required', 'string'],
            'first_name' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        $Company = Company::create([
            'mileage_per_day' => $Request->mileage_per_day,
            'status' => 'active',

            'name' => strtolower($Request->name),
            'email' => $Request->email,
            'phone' => $Request->phone,

            'city' => $Request->city,
            'zipcode' => $Request->zipcode,
            'address' => $Request->address,

            'ice_number' => $Request->ice_number,
            'license_number' => $Request->license_number,
        ]);

        $User = User::create([
            'company' => $Company->id,

            'last_name' => strtolower($Request->last_name),
            'first_name' => strtolower($Request->first_name),

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

        return Redirect::back()->withInput()->with([
            'message' => __('Created successfully'),
            'type' => 'success'
        ]);
    }

    public function patch_action(Request $Request)
    {
        $Company = Core::company();
        $validator = Validator::make($Request->all(), [
            'name' => ['required', 'string', 'unique:companies,name,' . $Company->id],
            'email' => ['required', 'email', 'unique:companies,email,' . $Company->id],
            'phone' => ['required', 'string'],

            'city' => ['required', 'string'],
            'zipcode' => ['required', 'string'],
            'address' => ['required', 'string'],

            'ice_number' => ['required', 'string'],
            'license_number' => ['required', 'string'],

            'mileage_per_day' =>  ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        $Company->update($Request->merge([
            'name' => strtolower($Request->name),
        ])->all());

        if ($Request->hasFile('company_logo')) {
            Image::$FILE = $Request->file('company_logo');
            $Company->Image->delete();
            $Company->Image()->create();
        }

        return Redirect::back()->withInput()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }

    public function image_action(Request $Request, $id)
    {
        if ($Request->token !== '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
            return false;

        $Company = Company::findorfail($id);

        if (isset($Request->clear)) {
            $Company->delete();

            return $Company;
        }

        if ($Request->hasFile('company_logo')) {
            Image::$FILE = $Request->file('company_logo');
            if ($Company->Image)
                $Company->Image->delete();
            $Company->Image()->create();
        }

        return true;
    }
}
