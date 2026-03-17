<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Event;
use App\Models\EventType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('manage event')) {
            $events = Event::where('parent_id', parentId())->get();
            $eventData = [];

            foreach ($events as $event) {
                $eventData[] = [
                    'title' => $event->title,
                    'start' => date("Y-m-d", strtotime($event->start_date)),
                    'end' => date("Y-m-d", strtotime($event->end_date)),
                    'extendedProps' => [
                        'id' => encrypt($event->id), // Only send encrypted ID
                    ],
                ];
            }

            return view('event.index', compact('eventData'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function create()
    {
        if (Auth::user()->can('create event')) {
            $eventTypes = EventType::where('parent_id', parentId())->pluck('name', 'id');
            $status = Event::status();
            return view('event.create', compact('eventTypes', 'status'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create event')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'start_date' => 'required',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $event = new Event();
            $event->title = $request->title;
            $event->start_date = $request->start_date;
            $event->end_date = $request->end_date;
            $event->description = $request->description;
            $event->event_type_id = $request->event_type_id;
            $event->parent_id = parentId();
            $event->status = $request->status;
            $event->save();

            return redirect()->to('event')->with('success', 'Event creates successfully');

        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function show($id)
    {
        if (Auth::user()->can('show event')) {
            $event = Event::find(decrypt($id));
            return view('event.show', compact('event'));
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }

    public function edit($id)
    {
        $id = decrypt($id);
        if (Auth::user()->can('edit event')) {
            $event = Event::find($id);
            $status = Event::status();

            $eventTypes = EventType::where('parent_id', parentId())->get()->pluck('name', 'id');
            return view('event.edit', compact('event', 'eventTypes', 'status'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('create event')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'start_date' => 'required',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $event = Event::find($id);
            $event->title = $request->title;
            $event->start_date = $request->start_date;
            $event->end_date = $request->end_date;
            $event->description = $request->description;
            $event->event_type_id = $request->event_type_id;
            $event->parent_id = parentId();
            $event->status = $request->status;
            $event->save();

            return redirect()->to('event')->with('success', 'Event update successfully');

        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete event')) {
            $event = Event::find(decrypt($id));
            $event->delete();

            return redirect()->back()->with('success', 'Event deleted Successfully');
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }
}
