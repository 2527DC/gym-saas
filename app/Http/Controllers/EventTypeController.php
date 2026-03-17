<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Auth;
use Illuminate\Http\Request;
use Validator;

class EventTypeController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('manage event type')) {
            $eventtypes = EventType::where('parent_id', parentId())->orderBy('id', 'desc')->get();
            return view('event_type.index', compact('eventtypes'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function create()
    {
        return view('event_type.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create event type')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $eventType = new EventType();
            $eventType->name = $request->name;
            $eventType->parent_id = parentId();
            $eventType->save();
            return redirect()->back()->with('success', '');
        } else {
            return redirect()->back()->with('error', '');
        }
    }

    public function show()
    {
        //
    }

    public function edit($id)
    {
        if (Auth::user()->can('edit event type')) {
            $eventtype = EventType::find(decrypt($id));
            return view('event_type.edit', compact('eventtype'));
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('edit event type')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $eventType = EventType::find($id);
            $eventType->name = $request->name;
            $eventType->save();

            return redirect()->back()->with('success', 'Event type updated succsessfully');
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete event type')) {
            $eventType = EventType::find($id);
            $eventType->delete();
            return redirect()->back()->with('success', 'event type deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Permissiosn denied.');
        }
    }
}
