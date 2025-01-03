<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Models\Recovery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class RecoveryController extends Controller
{
    public function index_view()
    {
        return view('recovery.index');
    }

    public function patch_view($id)
    {
        $data = Recovery::with('Reservation')->findorfail($id);
        return view('recovery.patch', compact('data'));
    }

    public function search_action(Request $Request)
    {
        $data = Recovery::with([
            'Reservation.Vehicle' =>  function ($Query) {
                $Query->select('id', "brand", 'model', 'year', 'registration_number');
            },
            'Reservation.Client' =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Reservation.SClient'  =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Reservation.Agency' =>  function ($Query) {
                $Query->select('id', "name");
            }
        ])->where('company', Core::company('id'))->where('status', '!=', 'completed')->orderBy('id', 'DESC');

        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            $carry->dropoff_date = $carry->Reservation->dropoff_date;
            $carry->reference = $carry->Reservation->reference;
            $carry->vehicle = $carry->Reservation->Vehicle;
            $carry->sclient = $carry->Reservation->SClient;
            $carry->client = $carry->Reservation->Client;
            $carry->agency = $carry->Reservation->Agency;
            unset($carry->Reservation);
            return $carry;
        });
        return response()->json($data);
    }

    public function filter_action(Request $Request)
    {
        $data = Recovery::with([
            'Reservation.Vehicle' =>  function ($Query) {
                $Query->select('id', "brand", 'model', 'year', 'registration_number');
            },
            'Reservation.Client' =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Reservation.SClient'  =>  function ($Query) {
                $Query->select('id', "last_name", 'first_name');
            },
            'Reservation.Agency' =>  function ($Query) {
                $Query->select('id', "name");
            }
        ])->where('company', Core::company('id'))->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            $carry->dropoff_date = $carry->Reservation->dropoff_date;
            $carry->reference = $carry->Reservation->reference;
            $carry->vehicle = $carry->Reservation->Vehicle;
            $carry->sclient = $carry->Reservation->SClient;
            $carry->client = $carry->Reservation->Client;
            $carry->agency = $carry->Reservation->Agency;
            unset($carry->Reservation);
            return $carry;
        });
        return response()->json($data);
    }

    public function patch_action(Request $Request, $id)
    {
        $validator = Validator::make($Request->all(), [
            'mileage' => ['required', 'numeric'],
            'fuel_level' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        Recovery::findorfail($id)->update($Request->all());

        return Redirect::back()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }
}
