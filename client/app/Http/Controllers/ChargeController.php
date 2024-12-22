<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Models\Charge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class ChargeController extends Controller
{
    public function index_view()
    {
        return view('charge.index');
    }

    public function store_view()
    {
        return view('charge.store');
    }

    public function patch_view($id)
    {
        $data = Charge::findorfail($id);
        return view('charge.patch', compact('data'));
    }

    public function search_action(Request $Request)
    {
        $data = Charge::with([
            'Vehicle' =>  function ($Query) {
                $Query->select('id', "brand", 'model', 'year', 'registration_number');
            },
        ])->where('company', Core::company('id'))->orderBy('id', 'DESC');
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
            'name' => ['required', 'string'],
            'cost' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        Charge::create($Request->all());

        return Redirect::back()->withInput()->with([
            'message' => __('Created successfully'),
            'type' => 'success'
        ]);
    }

    public function patch_action(Request $Request, $id)
    {
        $validator = Validator::make($Request->all(), [
            'vehicle' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'cost' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        Charge::findorfail($id)->update($Request->all());

        return Redirect::back()->withInput()->with([
            'message' => __('Created successfully'),
            'type' => 'success'
        ]);
    }

    public function clear_action($id)
    {
        Charge::findorfail($id)->delete();

        return Redirect::route('views.charges.index')->withInput()->with([
            'message' => __('Deleted successfully'),
            'type' => 'success'
        ]);
    }
}
