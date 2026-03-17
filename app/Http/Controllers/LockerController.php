<?php

namespace App\Http\Controllers;

use App\Models\AssignLocker;
use App\Models\Locker;
use App\Models\Notification;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class LockerController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('manage locker')) {
            $lockers = Locker::where('parent_id', parentId())->orderBy('id', 'desc')->get();
            return view('locker.index', compact('lockers'));
        } else {
            return redirect()->back()->with('error', 'permission denied');
        }
    }

    public function create()
    {
        $status = Locker::$status;
        $available = Locker::$available;
        return view('locker.create', compact('status', 'available'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create locker')) {
            $locker = new Locker();
            $locker->status = $request->status ?? 1;
            $locker->available = $request->available ?? 1;
            $locker->parent_id = parentId();
            $locker->save();

            return redirect()->back()->with('success', 'Locker created successfully');
        } else {
            return redirect()->back()->with('error', 'Permssion denied');
        }
    }

    public function show($id)
    {
        $locker = Locker::find(decrypt($id));
        $assignLockers = AssignLocker::where('locker_id', $locker->id)->get();
        $setting = settings();
        return view('locker.show', compact('locker', 'assignLockers', 'setting'));
    }

    public function edit($id)
    {
        $status = Locker::$status;
        $available = Locker::$available;
        $locker = Locker::find(decrypt($id));
        return view('locker.edit', compact('status', 'available', 'locker'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('edit locker')) {
            return redirect()->back()->with('error', 'Permission denied');
        }

        $assigned = AssignLocker::where('locker_id', $id)
            ->whereNull('end_date')
            ->exists();

        if ($assigned) {
            return redirect()->back()->with('error', 'Locker is currently assigned and cannot be updated.');
        }

        $locker = Locker::find($id);
        $locker->status = $request->status ?? 1;
        $locker->available = $request->available ?? 1;
        $locker->save();

        return redirect()->back()->with('success', 'Locker updated successfully');
    }


    public function destroy($id)
    {
        if (!Auth::user()->can('delete locker')) {
            return redirect()->back()->with('error', 'Permission denied');
        }
        $id = decrypt($id);
        $locker = Locker::find($id);
        $assigned = AssignLocker::where('locker_id', $locker->id)
            ->whereNull('end_date')
            ->exists();

        if ($assigned) {
            return redirect()->back()->with('error', 'Locker is currently assigned and cannot be deleted.');
        }

        AssignLocker::where('locker_id', $locker->id)->delete();
        $locker->delete();


        return redirect()->back()->with('success', 'Locker deleted successfully deleted');
    }

    public function assignLocker($id)
    {
        if (Auth::user()->can('create assign locker')) {
            $users = User::where('parent_id', parentId())->whereIn('type', ['trainer', 'trainee'])->pluck('name', 'id');
            return view('locker.assign', compact('users', 'id'));
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }

    public function assignLockerStore(Request $request)
    {
        if (Auth::user()->can('create assign locker')) {

            $assignLocker = new AssignLocker();
            $assignLocker->user_id = $request->user_id;
            $assignLocker->locker_id = $request->locker_id;
            $assignLocker->assign_date = $request->assign_date ?? now();
            $assignLocker->save();

            $locker = Locker::find($request->locker_id);
            $locker->available = 0;
            $locker->save();

            $module = 'locker_assign';
            $assignLocker = AssignLocker::find($assignLocker->id);

            $notification = Notification::where('parent_id', parentId())->where('module', $module)->first();
            $setting = settings();
            $errorMessage = '';
            if (!empty($notification) && $notification->enabled_email == 1) {
                $notification_responce = MessageReplace($notification, $assignLocker->id);
                $data['subject'] = $notification_responce['subject'];
                $data['message'] = $notification_responce['message'];
                $data['module'] = $module;
                $data['logo'] = $setting['company_logo'];
                $to = $assignLocker->user->email;
                $response = commonEmailSend($to, $data);
                if ($response['status'] == 'error') {
                    $errorMessage = $response['message'];
                }
            }
            return redirect()->back()->with('success', 'Locker is assigned to user' . $errorMessage);
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }


    public function assignLockerEdit($id)
    {
        if (Auth::user()->can('edit assign locker')) {
            $assignLocker = AssignLocker::find($id);
            return view('locker.edit-assign', compact('assignLocker'));
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }

    public function assignLockerUpdate(Request $request, $id)
    {
        if (Auth::user()->can('edit assign locker')) {
            $assignLocker = AssignLocker::find($id);
            $assignLocker->end_date = $request->end_date;
            $assignLocker->update();

            $locker = Locker::find($assignLocker->locker_id);
            $locker->available = 1;
            $locker->save();
            return redirect()->back()->with('success', 'Assigned locker has been ended and is now available.');
        } else {
            return redirect()->back()->with('error', 'Permssion denied');
        }
    }
}
