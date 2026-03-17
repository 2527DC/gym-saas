<?php

namespace App\Http\Controllers;

use App\Models\WorkoutActivity;
use Illuminate\Http\Request;

class WorkoutActivityController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage workout activity')) {
            $activities = WorkoutActivity::where('parent_id', parentId())->orderBy('id', 'desc')->get();
            return view('activity.index', compact('activities'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function create()
    {
        return view('activity.create');
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create workout activity')) {
            $validator = \Validator::make(
                $request->all(), [
                    'title' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $activity = new WorkoutActivity();
            $activity->title = $request->title;
            $activity->parent_id = parentId();
            $activity->save();

            return redirect()->route('activity.index')->with('success', __('Workout activity successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function show(WorkoutActivity $workoutActivity)
    {
        //
    }


    public function edit($id)
    {
        $workoutActivity=WorkoutActivity::find($id);
        return view('activity.edit', compact('workoutActivity'));
    }


    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit workout activity')) {
            $validator = \Validator::make(
                $request->all(), [
                    'title' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $workoutActivity=WorkoutActivity::find($id);
            $workoutActivity->title = $request->title;
            $workoutActivity->save();

            return redirect()->route('activity.index')->with('success', __('Workout activity successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function destroy($id)
    {
        if (\Auth::user()->can('delete workout activity') ) {
            $workoutActivity=WorkoutActivity::find($id);
            $workoutActivity->delete();
            return redirect()->route('activity.index')->with('success', __('Workout activity successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
