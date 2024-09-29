<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    public function index_view()
    {
        return view('payment.index');
    }

    public function patch_view($id)
    {
        $data = Payment::with('Reservation')->findorfail($id);
        return view('payment.patch', compact('data'));
    }

    public function print_view($id)
    {
        $data = Reservation::with('Client', 'Vehicle', 'Agency')->findorfail($id);
        return view('payment.print', compact('data'));
    }

    public function search_action(Request $Request)
    {
        $data = Payment::with('Owner', 'Reservation')->where('status', '!=', 'completed')->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            $carry->vehicle = $carry->Reservation->Vehicle;
            $carry->sclient = $carry->Reservation->SClient;
            $carry->client = $carry->Reservation->Client;
            $carry->agency = $carry->Reservation->Agency;

            return $carry;
        });
        return response()->json($data);
    }

    public function filter_action(Request $Request)
    {
        $data = Payment::with('Owner', 'Reservation')->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50)->through(function ($carry) {
            $carry->vehicle = $carry->Reservation->Vehicle;
            $carry->sclient = $carry->Reservation->SClient;
            $carry->client = $carry->Reservation->Client;
            $carry->agency = $carry->Reservation->Agency;

            return $carry;
        });
        return response()->json($data);
    }

    public function patch_action(Request $Request, $id)
    {
        $payment = collect(json_decode($Request->payment));

        $Payment = Payment::findorfail($id);
        $Payment->update([
            'logs' => $Request->payment,
            'paid' => $payment->sum('amount'),
            'rest' => $Payment->total - $payment->sum('amount'),
            'status' => $payment->sum('amount') >= $Payment->total ? 'completed' : 'pending'
        ]);

        $Payment->Reservation->update([
            'status' => $payment->sum('amount') >= $Payment->total ? 'completed' : 'pending'
        ]);

        $Payment->Reservation->Recovery->update([
            'status' => $payment->sum('amount') >= $Payment->total ? 'completed' : 'pending'
        ]);

        return Redirect::back()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }
}
