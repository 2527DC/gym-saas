<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Notification;
use App\Models\TraineeDetail;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage attendance')) {
            if (\Auth::user()->type == 'trainer') {
                $assignTrainee = TraineeDetail::where('trainer_assign', \Auth::user()->id)->get()->pluck('user_id')->toArray();
                $attendances = Attendance::whereIn('user_id', $assignTrainee)->orderBy('id', 'desc')->get();
            } elseif (\Auth::user()->type == 'trainee') {

                $attendances = Attendance::where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->get();
            } else {
                $attendances = Attendance::where('parent_id', parentId())->orderBy('id', 'desc')->get();
            }
            return view('attendance.index', compact('attendances'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function create()
    {
        $users = User::where('parent_id', parentId())->get()->pluck('name', 'id');
        $users->prepend(__('Select Trainee'), '');

        return view('attendance.create', compact('users'));
    }

    public function bulk(Request $request)
    {
        $type = $request->input('type', null);
        $date = $request->input('date', date('Y-m-d'));
        $users = [];

        if ($type === 'trainer') {
            $users = User::where('type', 'trainer')->where('parent_id', parentId())->pluck('name', 'id');
        } elseif ($type === 'trainee') {
            $users = User::where('type', 'trainee')->where('parent_id', parentId())->pluck('name', 'id');
        } else {
            $users = [];
        }

        return view('attendance.bulk', compact('users', 'type', 'date'));
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create attendance')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    'date' => 'required',
                    'checked_in_time' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $attendance = new Attendance();
            $attendance->user_id = $request->user_id;
            $attendance->date = $request->date;
            $attendance->checked_in_time = $request->checked_in_time;
            $attendance->checked_out_time = $request->checked_out_time;
            $attendance->notes = $request->notes;
            $attendance->parent_id = parentId();
            $attendance->save();


            $module = 'attendance_create';
            $notification = Notification::where('parent_id', parentId())->where('module', $module)->first();
            $setting = settings();
            $errorMessage = '';

            if (!empty($notification) && $notification->enabled_email == 1) {
                $notificationResponse = MessageReplace($notification, $attendance->id);

                $data['subject'] = $notificationResponse['subject'];
                $data['message'] = $notificationResponse['message'];
                $data['module'] = $module;
                $data['logo'] = $setting['company_logo'];
                $to = $attendance->users->email;

                $response = commonEmailSend($to, $data);

                if ($response['status'] == 'error') {
                    $errorMessage = $response['message'];
                }
            }


            return redirect()->route('attendances.index')->with('success', __('Attendance successfully created.') . '</br>' . $errorMessage);
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function bulkAttendanceStore(Request $request)
    {
        $attendances = $request->input('attendances', []);

        foreach ($attendances as $attendanceData) {
            $attendance = new Attendance();
            $attendance->user_id = $attendanceData['user_id'];
            $attendance->date = $request->input('date');
            $attendance->status = isset($attendanceData['present']) ? 1 : 0;
            $attendance->checked_in_time = $attendanceData['checked_in_time'] ?? null;
            $attendance->checked_out_time = $attendanceData['checked_out_time'] ?? null;
            $attendance->notes = 'Daily Attendance Record';
            $attendance->parent_id = parentId();
            $attendance->save();
        }

        return redirect()->route('attendances.index')->with('success', 'Bulk attendance recorded successfully.');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $attendance = Attendance::find(decrypt($id));
        $users = User::where('parent_id', parentId())->get()->pluck('name', 'id');
        $users->prepend(__('Select Trainee'), '');

        return view('attendance.edit', compact('users', 'attendance'));
    }


    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit attendance')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    'date' => 'required',
                    'checked_in_time' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $attendance = Attendance::find($id);
            $attendance->user_id = $request->user_id;
            $attendance->date = $request->date;
            $attendance->checked_in_time = $request->checked_in_time;
            $attendance->checked_out_time = $request->checked_out_time;
            $attendance->notes = $request->notes;
            $attendance->save();

            return redirect()->route('attendances.index')->with('success', __('Attendance successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function destroy($id)
    {
        if (\Auth::user()->can('delete attendance')) {
            $attendance = Attendance::find(decrypt($id));
            $attendance->delete();
            return redirect()->route('attendances.index')->with('success', __('Attendance successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function todayAttendance()
    {
        if (\Auth::user()->can('manage today attendance')) {
            if (\Auth::user()->type == 'trainer') {
                $assignTrainee = TraineeDetail::where('trainer_assign', \Auth::user()->id)->get()->pluck('user_id')->toArray();
                $attendances = Attendance::whereIn('user_id', $assignTrainee)->where('date', date('Y-m-d'))->get();
            } elseif (\Auth::user()->type == 'trainee') {
                $attendances = Attendance::where('user_id', \Auth::user()->id)->where('date', date('Y-m-d'))->get();
            } else {
                $attendances = Attendance::where('parent_id', parentId())->where('date', date('Y-m-d'))->get();
            }
            return view('attendance.today', compact('attendances'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
