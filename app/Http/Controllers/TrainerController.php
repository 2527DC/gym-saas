<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ClassAssign;
use App\Models\Classes;
use App\Models\Notification;
use App\Models\Subscription;
use App\Models\TraineeDetail;
use App\Models\TrainerDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;
use Storage;

class TrainerController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage trainer')) {
            $trainers = User::where('parent_id', parentId())->where('type', 'trainer')->orderBy('id', 'desc')->get();
            return view('trainer.index', compact('trainers'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function create()
    {
        $gender = User::$gender;

        $classes = Classes::where('parent_id', parentId())->get()->pluck('title', 'id');

        return view('trainer.create', compact('gender', 'classes'));
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create user')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'dob' => 'required',
                    'password' => 'required|min:6',
                    'gender' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $ids = parentId();
            $authUser = User::find($ids);
            $totalTrainer = $authUser->totalTrainer();
            $subscription = Subscription::find($authUser->subscription);
            if ($totalTrainer >= $subscription->trainer_limit && $subscription->trainer_limit != 0) {
                return redirect()->back()->with('error', __('Your trainer limit is over, please upgrade your subscription.'));
            }
            $profileFileName = 'avatar.png';

            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                $dir = storage_path('uploads/profile/');
                $imagePath = $dir . $authUser->avatar;

                if (\File::exists($imagePath)) {
                    \File::delete($imagePath);
                }

                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $file->storeAs('upload/profile/', $fileNameToStore);
                $profileFileName = $fileNameToStore;
            }
            $userRole = Role::where('parent_id', parentId())->where('name', 'trainer')->first();
            $document = '';
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                $dir = storage_path('app/upload/trainer_document/');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $file->storeAs('upload/trainer_document/', $fileNameToStore);

                $document = $fileNameToStore;
            }
            $trainer = new User();
            $trainer->name = $request->name;
            $trainer->email = $request->email;
            $trainer->phone_number = $request->phone_number;
            $trainer->password = \Hash::make($request->password);
            $trainer->type = !empty($userRole->name) ? $userRole->name : 'trainer';
            $trainer->profile = $profileFileName;
            $trainer->lang = 'english';
            $trainer->email_verified_at = now();
            $trainer->parent_id = parentId();
            $trainer->save();
            $trainer->assignRole($userRole);

            if (!empty($trainer)) {
                $trainerDetail = new TrainerDetail();
                $trainerDetail->user_id = $trainer->id;
                $trainerDetail->trainer_id = $this->trainerNumber();
                $trainerDetail->dob = $request->dob;
                $trainerDetail->gender = $request->gender;
                $trainerDetail->qualification = !empty($request->qualification) ? $request->qualification : '';
                $trainerDetail->country = !empty($request->country) ? $request->country : '';
                $trainerDetail->state = !empty($request->state) ? $request->state : '';
                $trainerDetail->city = !empty($request->city) ? $request->city : '';
                $trainerDetail->zip_code = !empty($request->zip_code) ? $request->zip_code : '';
                $trainerDetail->address = !empty($request->address) ? $request->address : '';
                $trainerDetail->parent_id = parentId();
                $trainerDetail->document = $document;
                $trainerDetail->status = 1;
                $trainerDetail->save();
            }
            if (!empty($request->assign_class)) {
                foreach ($request->assign_class as $classId) {
                    $class = new ClassAssign();
                    $class->classes_id = $classId;
                    $class->assign_id = $trainer->id;
                    $class->assign_type = 'trainer';
                    $class->save();
                }
            }


            $module = 'trainer_create';
            $notification = Notification::where('parent_id', parentId())->where('module', $module)->first();
            $notification->password = $request->password;
            $setting = settings();
            $errorMessage = '';
            if (!empty($notification) && $notification->enabled_email == 1) {
                $notification_responce = MessageReplace($notification, $trainer->id);
                $data['subject'] = $notification_responce['subject'];
                $data['message'] = $notification_responce['message'];
                $data['module'] = $module;
                $data['password'] = $request->password;
                $data['logo'] = $setting['company_logo'];
                $to = $trainer->email;

                $response = commonEmailSend($to, $data);
                if ($response['status'] == 'error') {
                    $errorMessage = $response['message'];
                }
            }


            return redirect()->route('trainers.index')->with('success', __('Trainer successfully created.') . '</br>' . $errorMessage);
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function show($ids)
    {
        $id = Crypt::decrypt($ids);
        $trainer = User::find($id);
        $trainerDetail = TrainerDetail::where('user_id', $id)->first();

        $trainees = TraineeDetail::where('trainer_assign', $id)->get();
        return view('trainer.show', compact('trainer', 'trainerDetail', 'trainees'));
    }


    public function edit($id)
    {
        $gender = User::$gender;
        $trainer = User::find(decrypt($id));

        $category = Category::where('parent_id', parentId())->get()->pluck('title', 'id');
        $category->prepend(__('Select Category'), '');

        $status = TrainerDetail::$status;


        return view('trainer.edit', compact('trainer', 'gender', 'category', 'status'));
    }


    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit trainer')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $id,
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $userRole = Role::where('parent_id', parentId())->where('name', 'trainer')->first();

            $trainer = User::findOrFail($id);
            $profileFileName = $trainer->profile ?? 'avatar.png';

            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                $dir = storage_path('uploads/profile/');
                $imagePath = $dir . $trainer->profile;

                if ($trainer->profile && $trainer->profile !== 'avatar.png' && Storage::exists('upload/profile/' . $trainer->profile)) {
                    Storage::delete('upload/profile/' . $trainer->profile);
                }

                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $file->storeAs('upload/profile/', $fileNameToStore);
                $profileFileName = $fileNameToStore;
            }
            $document = '';
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                $dir = storage_path('app/upload/trainer_document/');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $file->storeAs('upload/trainer_document/', $fileNameToStore);

                $document = $fileNameToStore;
            }
            $trainer->name = $request->name;
            $trainer->email = $request->email;
            $trainer->phone_number = $request->phone_number;
            $trainer->type = !empty($userRole->name) ? $userRole->name : 'trainer';
            $trainer->profile = $profileFileName;
            $trainer->save();
            $trainer->roles()->sync($userRole);
            if (!empty($trainer)) {
                $trainerDetail = TrainerDetail::where('user_id', $id)->first();
                $trainerDetail->dob = $request->dob;
                $trainerDetail->gender = $request->gender;
                $trainerDetail->qualification = !empty($request->qualification) ? $request->qualification : '';
                $trainerDetail->country = !empty($request->country) ? $request->country : '';
                $trainerDetail->state = !empty($request->state) ? $request->state : '';
                $trainerDetail->city = !empty($request->city) ? $request->city : '';
                $trainerDetail->zip_code = !empty($request->zip_code) ? $request->zip_code : '';
                $trainerDetail->address = !empty($request->address) ? $request->address : '';
                $trainerDetail->status = $request->status;
                $trainerDetail->document = $document;
                $trainerDetail->save();
            }

            return redirect()->route('trainers.index')->with('success', 'Trainer successfully updated.');
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function destroy($id)
    {
        if (\Auth::user()->can('delete trainer')) {
            $trainer = User::find(decrypt($id));
            $trainer->delete();
            if (!empty($trainer)) {
                $trainerDetail = TrainerDetail::where('user_id', decrypt($id))->first();
                $trainerDetail->delete();
            }
            ClassAssign::where('assign_id', decrypt($id))->delete();
            return redirect()->route('trainers.index')->with('success', __('Trainer successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    function trainerNumber()
    {
        $latest = TrainerDetail::where('parent_id', parentId())->latest()->first();
        if (!$latest) {
            return 1;
        }
        return $latest->trainer_id + 1;
    }
}
