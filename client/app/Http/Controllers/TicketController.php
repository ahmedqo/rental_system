<?php

namespace App\Http\Controllers;

use App\Functions\Core;
use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function store_view()
    {
        return view('ticket.store');
    }

    public function scene_view($id)
    {
        $data = Ticket::with('Owner', 'Comments')->findorfail($id);
        return view('ticket.scene', compact('data'));
    }

    public function search_action(Request $Request)
    {
        $data = Ticket::where('company', Core::company('id'))->where('status', '!=', 'closed')->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function filter_action(Request $Request)
    {
        $data = Ticket::where('company', Core::company('id'))->orderBy('id', 'DESC');
        if ($Request->search) {
            $data = $data->search(urldecode($Request->search));
        }
        $data = $data->cursorPaginate(50);
        return response()->json($data);
    }

    public function store_action(Request $Request)
    {
        $validator = Validator::make($Request->all(), [
            'subject' => ['required', 'string'],
            'category' => ['required', 'string'],
            'content' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        $Ticket = Ticket::create($Request->merge([
            'awaiting_response_from' => 'App\Models\Admin',
            'reference' => Core::ref(Ticket::class),
            'status' => 'open'
        ])->all());

        Auth::user()->Comment()->create([
            'ticket' => $Ticket->id,
            'content' => $Request->content,
        ]);

        return Redirect::route('views.tickets.scene', $Ticket->id)->with([
            'message' => __('Created successfully'),
            'type' => 'success'
        ]);
    }

    public function patch_action(Request $Request, $id)
    {
        $validator = Validator::make($Request->all(), [
            'content' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->with([
                'message' => $validator->errors()->all(),
                'type' => 'error'
            ]);
        }

        $Ticket = Ticket::findorfail($id);
        $Ticket->update([
            'awaiting_response_from' => 'App\Models\Admin',
        ]);

        Auth::user()->Comment()->create([
            'ticket' => $Ticket->id,
            'content' => $Request->content,
        ]);

        return Redirect::back()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }

    public function close_action(Request $Request, $id)
    {

        Ticket::findorfail($id)->update([
            'status' => 'closed'
        ]);

        return Redirect::back()->with([
            'message' => __('Updated successfully'),
            'type' => 'success'
        ]);
    }
}
