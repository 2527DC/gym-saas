<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage notification')) {
            $notifications = Notification::where('parent_id', parentId())->orderBy('id', 'desc')->get();
            return view('notification.index', compact('notifications'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        $Notifications = Notification::$modules;
        $notification_option = [];
        foreach ($Notifications as $key => $value) {
            $notification_option[$key] = $value['name'];
        }
        return view('notification.create', compact('notification_option', 'Notifications'));
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create notification')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'module' => 'required',
                    'subject' => 'required',
                    'message' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $exist = Notification::where('parent_id', parentId())->where('module', $request->module)->first();
            if (empty($exist)) {
                $notification = new Notification();
                $notification->module = $request->module;
                $notification->subject = $request->subject;
                $notification->message = $request->message;
                $notification->sms_message = $request->sms_message;
                $notification->enabled_email = isset($request->enabled_email) ? 1 : 0;
                $notification->enabled_sms = isset($request->enabled_sms) ? 1 : 0;
                $notification->parent_id = parentId();
                $notification->save();

                return redirect()->route('notification.index')->with('success', __('Notification successfully created.'));
            } else {
                return redirect()->back()->with('error', __('Notification already exist'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Notification $notification)
    {
        //
    }

    public function edit(Notification $notification)
    {
        $short_code=$notification->short_code;
        $notification->short_code = json_decode($notification->short_code);

        $Notifications = Notification::$modules;
        $notification_option = [];
        foreach ($Notifications as $key => $value) {
            $notification_option[$key] = $value['name'];
        }
        return view('notification.edit', compact('notification', 'notification_option', 'Notifications'));
    }

    public function update(Request $request, Notification $notification)
    {
        if (\Auth::user()->can('edit notification')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'subject' => 'required',
                    'message' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $notification->subject = $request->subject;
            $notification->message = $request->message;
            $notification->sms_message = $request->sms_message;
            $notification->enabled_email = $request->enabled_email;
            $notification->enabled_sms = $request->enabled_sms;
            $notification->save();

            return redirect()->route('notification.index')->with('success', __('Notification successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Notification $notification)
    {
        if (\Auth::user()->can('delete notification')) {
            $notification->delete();
            return redirect()->back()->with('success', __('Notification successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
