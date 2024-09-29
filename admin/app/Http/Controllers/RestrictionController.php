<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Models\Restriction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class RestrictionController extends Controller
{
    public function index_view()
    {
        return view('restriction.index');
    }

    public function store_view()
    {
        return view('restriction.store');
    }

    public function patch_view($id)
    {
        $data = Restriction::findorfail($id);
        return view('restriction.patch', compact('data'));
    }

    public function search_action(Request $Request)
    {
        $data = Restriction::with('Owner', 'Client')->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function store_action(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'client' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        Restriction::create($Request->all());

        return Redirect::back()->with([
            'message' => __('Created successfully'),
            'type' => 'success'
        ]);
    }

    public function patch_action(Request $Request, $id)
    {
        $validator = Validator::make($Request->all(), [
            'client' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        Restriction::findorfail($id)->update($Request->all());

        return Redirect::back()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }

    public function clear_action($id)
    {
        Restriction::findorfail($id)->delete();

        return Redirect::route('views.restrictions.index')->with([
            'message' => __('Deleted successfully'),
            'type' => 'success'
        ]);
    }
}
