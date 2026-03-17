<?php

namespace App\Http\Controllers;

use App\Models\NutritionSchedule;
use App\Models\TraineeDetail;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Validator;

class NutritionScheduleController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('manage nutrition schedule')) {
            if (Auth::user()->type == 'trainer') {
                $assignTrainee = TraineeDetail::where('trainer_assign', Auth::user()->id)->get()->pluck('user_id')->toArray();
                $nutritionSchedules = NutritionSchedule::whereIn('user_id', $assignTrainee)->orderBy('id', 'desc')->get();
            } elseif (Auth::user()->type == 'trainee') {

                $nutritionSchedules = NutritionSchedule::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
            } else {
                $nutritionSchedules = NutritionSchedule::where('parent_id', parentId())->orderBy('id', 'desc')->get();
            }
            return view('nutrition_schedule.index', compact('nutritionSchedules'));
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }

    public function create()
    {
        $trainee = User::where('parent_id', parentId())->where('type', 'trainee')->get()->pluck('name', 'id');
        $trainee->prepend(__('Select Trainee'), '');
        return view('nutrition_schedule.create', compact('trainee'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create nutrition schedule')) {
            $validator = Validator::make($request->all(), [
                'trainee' => 'required',
                'start_date' => 'required',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $nutritionSchedule = new NutritionSchedule();
            $nutritionSchedule->parent_id = parentId();
            $nutritionSchedule->start_date = $request->start_date;
            $nutritionSchedule->end_date = $request->end_date;
            $nutritionSchedule->user_id = $request->trainee;

            $scheduleData = [
                'selected_days' => $request->selected_days,
                'daily_nutrition_plan' => [
                    'meals' => $request->meals ?? [],
                    'meal_descriptions' => $request->meal_description ?? [],
                ],
            ];

            $nutritionSchedule->schedules = json_encode($scheduleData);
            $nutritionSchedule->save();

            return redirect()->route('nutrition-schedule.index')->with('success', 'Nuetrition schedule created successfully');
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }

    public function show($id)
    {
        if (Auth::user()->can('show nutrition schedule')) {
            $nutritionSchedule = NutritionSchedule::find(decrypt($id));
            return view('nutrition_schedule.show', compact('nutritionSchedule'));
        } else {
            return redirect()->back()->with('error', 'Permisison denied');
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete nutrition schedule')) {
            $nutritionSchedule = NutritionSchedule::find(decrypt($id));
            $nutritionSchedule->delete();
            return redirect()->back()->with('success', 'Nutrition schedule deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }
}
