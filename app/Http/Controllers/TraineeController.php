<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ClassAssign;
use App\Models\Classes;
use App\Models\Health;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Membership;
use App\Models\Notification;
use App\Models\NutritionSchedule;
use App\Models\Subscription;
use App\Models\TraineeDetail;
use App\Models\TrainerDetail;
use App\Models\Type;
use App\Models\User;
use App\Models\Workout;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;
use Storage;

class TraineeController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('manage trainee')) {
            if (\Auth::user()->type == 'trainer') {
                $assignTrainee = TraineeDetail::where('trainer_assign', \Auth::user()->id)->get()->pluck('user_id')->toArray();
                $trainees = User::whereIn('id', $assignTrainee)->orderBy('id', 'desc')->get();
            } else {
                $trainees = User::where('parent_id', parentId())->where('type', 'trainee')->orderBy('id', 'desc')->get();
            }
            return view('trainee.index', compact('trainees'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function create()
    {
        $gender = User::$gender;
        $trainer = User::where('parent_id', parentId())->where('type', 'trainer')->get()->pluck('name', 'id');
        $trainer->prepend(__('Select Trainer'), '');

        $category = Category::where('parent_id', parentId())->get()->pluck('title', 'id');
        $category->prepend(__('Select Category'), '');

        $classes = Classes::where('parent_id', parentId())->get()->pluck('title', 'id');
        $classes->prepend(__('Select Class'), '');

        $membership = Membership::where('parent_id', parentId())->get()->pluck('title', 'id');
        $membership->prepend(__('Select Membership'), '');

        return view('trainee.create', compact('gender', 'trainer', 'category', 'classes', 'membership'));
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
                    'gender' => 'required',
                    'age' => 'required',
                    'category' => 'required',
                    'membership_plan' => 'required',
                    'fitness_goal' => 'required',
                    'membership_start_date' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $ids = parentId();
            $authUser = User::find($ids);
            $totalTrainee = $authUser->totalTrainee();
            $subscription = Subscription::find($authUser->subscription);
            if ($totalTrainee >= $subscription->trainee_limit && $subscription->trainee_limit != 0) {
                return redirect()->back()->with('error', __('Your user limit is over, please upgrade your subscription.'));
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
            $userRole = Role::where('parent_id', parentId())->where('name', 'trainee')->first();
            $trainee = new User();
            $trainee->name = $request->name;
            $trainee->email = $request->email;
            $trainee->phone_number = $request->phone_number;
            $trainee->password = \Hash::make($request->password);
            $trainee->type = !empty($userRole->name) ? $userRole->name : 'trainee';
            $trainee->profile = $profileFileName;
            $trainee->email_verified_at = now();
            $trainee->lang = 'english';
            $trainee->parent_id = parentId();
            $trainee->save();

            $trainee->assignRole($userRole);

            $document = '';
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                $dir = storage_path('app/upload/document/');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $file->storeAs('upload/document/', $fileNameToStore);

                $document = $fileNameToStore;
            }

            $expiryDate = Membership::calculateExpiryDate($request->membership_start_date, $request->membership_plan);
            if (!empty($trainee)) {
                $traineeDetail = new TraineeDetail();
                $traineeDetail->user_id = $trainee->id;
                $traineeDetail->trainee_id = $this->traineeNumber();
                $traineeDetail->dob = $request->dob;
                $traineeDetail->gender = $request->gender;
                $traineeDetail->age = $request->age;
                $traineeDetail->category = $request->category;
                $traineeDetail->trainer_assign = !empty($request->trainer_assign) ? $request->trainer_assign : 0;
                $traineeDetail->fitness_goal = !empty($request->fitness_goal) ? $request->fitness_goal : '';
                $traineeDetail->country = !empty($request->country) ? $request->country : '';
                $traineeDetail->state = !empty($request->state) ? $request->state : '';
                $traineeDetail->city = !empty($request->city) ? $request->city : '';
                $traineeDetail->zip_code = !empty($request->zip_code) ? $request->zip_code : '';
                $traineeDetail->address = !empty($request->address) ? $request->address : '';
                $traineeDetail->membership_plan = $request->membership_plan;
                $traineeDetail->membership_start_date = $request->membership_start_date;
                $traineeDetail->membership_expiry_date = $expiryDate;
                $traineeDetail->communication_preference = $request->communication_preference;
                $traineeDetail->document = $document;
                $traineeDetail->parent_id = parentId();
                $traineeDetail->status = 1;
                $traineeDetail->save();

                $this->scheduleReminders($trainee->id);
            }

            if (!empty($request->assign_class)) {
                $class = new ClassAssign();
                $class->classes_id = $request->assign_class;
                $class->assign_id = $trainee->id;
                $class->assign_type = 'trainee';
                $class->save();
            }


            $module = 'trainee_create';
            $notification = Notification::where('parent_id', parentId())->where('module', $module)->first();
            $notification->password = $request->password;
            $setting = settings();
            $errorMessage = '';
            if (!empty($notification)) {
                \Log::info('Trainee Notification Found for: ' . $module . ' (SMS Enabled: ' . $notification->enabled_sms . ')');
                $notification_responce = MessageReplace($notification, $trainee->id);
                
                if ($notification->enabled_email == 1) {
                    $data['subject'] = $notification_responce['subject'];
                    $data['message'] = $notification_responce['message'];
                    $data['module'] = $module;
                    $data['logo'] = $setting['company_logo'];
                    $to = $trainee->email;

                    $response = commonEmailSend($to, $data);
                    if ($response['status'] == 'error') {
                        $errorMessage = $response['message'];
                    }
                }

                if ($notification->enabled_sms == 1 && (!empty($traineeDetail->communication_preference) && ($traineeDetail->communication_preference == 'sms' || $traineeDetail->communication_preference == 'both'))) {
                    $smsBody = !empty($notification_responce['sms_message']) ? $notification_responce['sms_message'] : null;
                    if ($smsBody) {
                        $response = commonSmsSend($trainee->phone_number, $smsBody);
                        if ($response['status'] == 'error') {
                            $errorMessage .= ($errorMessage ? '<br>' : '') . $response['message'];
                        }
                    } else {
                        \Log::warning('Onboarding SMS skipped: SMS message template is empty for module: ' . $module);
                    }
                }
            }

            if (!empty($request->trainer_assign)) {
                $module = 'trainer_assign';
                $notification = Notification::where('parent_id', parentId())->where('module', $module)->first();
                $notification->password = $request->password;
                $trainerEmail = User::where('id', $request->trainer_assign)->pluck('email');
                $setting = settings();
                $errorMessage = '';
                if (!empty($notification) && $notification->enabled_email == 1) {
                    $notification_responce = MessageReplace($notification, $trainee->id);
                    $data['subject'] = $notification_responce['subject'];
                    $data['message'] = $notification_responce['message'];
                    $data['module'] = $module;
                    $data['password'] = $request->password;
                    $data['logo'] = $setting['company_logo'];
                    $to = $trainerEmail;

                    $response = commonEmailSend($to, $data);
                    if ($response['status'] == 'error') {
                        $errorMessage = $response['message'];
                    }
                }
            }



            return redirect()->route('trainees.index')->with('success', __('Trainee successfully created.') . '</br>' . $errorMessage);
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function show($ids)
    {
        $id = Crypt::decrypt($ids);
        $trainee = User::find($id);
        $traineeDetail = TraineeDetail::where('user_id', $id)->first();
        $invoices = Invoice::where('user_id', $id)->orderBy('id', 'desc')->get();
        $healthUpdates = Health::where('user_id', $id)->orderBy('id', 'desc')->get();
        $workouts = Workout::where('assign_id', $id)->orderBy('id', 'desc')->get();
        $nutritionSchedules = NutritionSchedule::where('user_id', $id)->orderBy('id', 'desc')->get();
        return view('trainee.show', compact('trainee', 'traineeDetail', 'invoices', 'healthUpdates', 'workouts', 'nutritionSchedules'));
    }


    public function edit($id)
    {
        $trainer = User::where('parent_id', parentId())->where('type', 'trainer')->get()->pluck('name', 'id');
        $trainer->prepend(__('Select Trainer'), '');

        $gender = User::$gender;
        $trainee = User::find(decrypt($id));

        $category = Category::where('parent_id', parentId())->get()->pluck('title', 'id');
        $category->prepend(__('Select Category'), '');

        $membership = Membership::where('parent_id', parentId())->get()->pluck('title', 'id');
        $membership->prepend(__('Select Membership'), '');

        $status = TraineeDetail::$status;

        return view('trainee.edit', compact('trainee', 'gender', 'trainer', 'category', 'membership', 'status'));
    }


    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit trainee')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,' . $id,
                    'dob' => 'required',
                    'gender' => 'required',
                    'age' => 'required',
                    'category' => 'required',
                    'membership_plan' => 'required',
                    'fitness_goal' => 'required',
                    'membership_start_date' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $userRole = Role::where('parent_id', parentId())->where('name', 'trainee')->first();
            $trainee = User::findOrFail($id);
            $profileFileName = $trainer->profile ?? 'avatar.png';

            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                $dir = storage_path('uploads/profile/');
                $imagePath = $dir . $trainee->profile;

                if ($trainee->profile && $trainee->profile !== 'avatar.png' && Storage::exists('upload/profile/' . $trainee->profile)) {
                    Storage::delete('upload/profile/' . $trainee->profile);
                }

                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $file->storeAs('upload/profile/', $fileNameToStore);
                $profileFileName = $fileNameToStore;
            }
            $trainee->name = $request->name;
            $trainee->email = $request->email;
            $trainee->phone_number = $request->phone_number;
            $trainee->type = !empty($userRole->name) ? $userRole->name : 'trainee';
            $trainee->profile = $profileFileName;
            $trainee->save();
            $trainee->roles()->sync($userRole);
            $expiryDate = Membership::calculateExpiryDate($request->membership_start_date, $request->membership_plan);
            $document = '';
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                $dir = storage_path('app/upload/document/');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $file->storeAs('upload/document/', $fileNameToStore);

                $document = $fileNameToStore;
            }
            if (!empty($trainee)) {
                $traineeDetail = TraineeDetail::where('user_id', $id)->first();
                $traineeDetail->dob = $request->dob;
                $traineeDetail->gender = $request->gender;
                $traineeDetail->age = $request->age;
                $traineeDetail->trainer_assign = !empty($request->trainer_assign) ? $request->trainer_assign : 0;
                $traineeDetail->fitness_goal = !empty($request->fitness_goal) ? $request->fitness_goal : '';
                $traineeDetail->country = !empty($request->country) ? $request->country : '';
                $traineeDetail->state = !empty($request->state) ? $request->state : '';
                $traineeDetail->city = !empty($request->city) ? $request->city : '';
                $traineeDetail->zip_code = !empty($request->zip_code) ? $request->zip_code : '';
                $traineeDetail->address = !empty($request->address) ? $request->address : '';
                $traineeDetail->category = $request->category;
                $traineeDetail->membership_plan = $request->membership_plan;
                $traineeDetail->membership_start_date = $request->membership_start_date;
                $traineeDetail->membership_expiry_date = $expiryDate;
                $traineeDetail->communication_preference = $request->communication_preference;
                $traineeDetail->document = $document;
                $traineeDetail->status = $request->status;
                $traineeDetail->save();

                $this->scheduleReminders($id);
            }

            return redirect()->route('trainees.index')->with('success', 'Trainee successfully updated.');
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function destroy($id)
    {
        if (\Auth::user()->can('delete trainee')) {
            $trainee = User::find(decrypt($id));
            $trainee->delete();
            if (!empty($trainee)) {
                $trainerDetail = TraineeDetail::where('user_id', decrypt($id))->first();
                $trainerDetail->delete();
            }

            ClassAssign::where('assign_id', decrypt($id))->delete();
            return redirect()->route('trainees.index')->with('success', __('Trainee successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    function traineeNumber()
    {
        $latest = TraineeDetail::where('parent_id', parentId())->latest()->first();
        if (!$latest) {
            return 1;
        }
        return $latest->trainee_id + 1;
    }

    public function membershipRenewal($id)
    {
        $membership = Membership::where('parent_id', parentId())->get()->pluck('title', 'id');
        $membership->prepend(__('Select Membership'), '');
        return view('membership.renew', compact('membership', 'id'));
    }

    public function membershipRenewalStore(Request $request)
    {
        $request->validate([
            'trainee_id' => 'required|exists:users,id',
            'membership_plan' => 'required|exists:memberships,id',
            'membership_start_date' => 'required|date',
        ]);

        $id = $request->trainee_id;
        $trainee = User::findOrFail($id);
        $membershipPlan = Membership::findOrFail($request->membership_plan);
        $newStartDate = $request->membership_start_date;
        $newExpiryDate = Membership::calculateExpiryDate($request->membership_start_date, $request->membership_plan);

        $traineeDetail = TraineeDetail::where('user_id', $id)->firstOrFail();
        $previousStartDate = $traineeDetail->membership_start_date ?? 'N/A';
        $previousExpiryDate = $traineeDetail->membership_expiry_date ?? 'N/A';

        $lastInvoiceId = Invoice::orderBy('invoice_id', 'desc')->value('invoice_id');
        $nextInvoiceId = $lastInvoiceId ? ((int) $lastInvoiceId + 1) : 1;

        $invoice = new Invoice();
        $invoice->invoice_id = $nextInvoiceId;
        $invoice->user_id = $id;
        $invoice->invoice_date = Carbon::now();
        $invoice->invoice_due_date = Carbon::now()->addDays(7);
        $invoice->status = 'unpaid';
        $invoice->parent_id = parentId();
        $invoice->save();

        $membershipFeeType = Type::where('title', 'Membership Fees')->where('parent_id', parentId())->first();

        $invoiceItem = new InvoiceItem();
        $invoiceItem->invoice_id = $invoice->id;
        $invoiceItem->type_id = $membershipFeeType->id ?? null;
        $invoiceItem->title = $membershipFeeType->title ?? 'Membership Fees';
        $invoiceItem->description = sprintf(
            'Fee charged for membership renewal: %s. Previous Start Date: %s, Previous Expiry Date: %s, New Start Date: %s, New Expiry Date: %s',
            $membershipPlan->title ?? 'Membership',
            $previousStartDate instanceof Carbon ? $previousStartDate->format('Y-m-d') : $previousStartDate,
            $previousExpiryDate instanceof Carbon ? $previousExpiryDate->format('Y-m-d') : $previousExpiryDate,
            Carbon::parse($newStartDate)->format('Y-m-d'),
            Carbon::parse($newExpiryDate)->format('Y-m-d')
        );
        $invoiceItem->amount = $membershipPlan->amount ?? 0;
        $invoiceItem->save();

        $traineeDetail->membership_plan = $request->membership_plan;
        $traineeDetail->membership_start_date = $newStartDate;
        $traineeDetail->membership_expiry_date = $newExpiryDate;
        $traineeDetail->save();

        $this->scheduleReminders($id);

        return redirect()->route('trainees.index')->with('success', 'Membership renewed successfully.');
    }

    private function scheduleReminders($userId)
    {
        $trainee = User::with('traineeDetail')->find($userId);
        $settings = settings();
        
        // Cancel existing reminders first
        $this->cancelReminders($userId);

        if (!$trainee || !$trainee->traineeDetail) return;

        $expiryDate = Carbon::parse($trainee->traineeDetail->membership_expiry_date);
        $scheduleDays = explode(',', $settings['reminder_auto_schedule_days'] ?? '7,3,1');
        
        $notification = Notification::where('parent_id', parentId())->where('module', 'membership_expiry_reminder')->first();
        if (!$notification) return;

        foreach ($scheduleDays as $days) {
            $scheduleDate = $expiryDate->copy()->subDays(trim($days));
            
            // Twilio allows scheduling between 1 hour and 35 days in advance
            if ($scheduleDate->isFuture() && $scheduleDate->diffInHours(now()) >= 1) {
                $reminder = new Reminder();
                $reminder->user_id = $userId;
                $reminder->type = 'membership_expiry';
                $reminder->scheduled_at = $scheduleDate;
                $reminder->status = 'pending';
                $reminder->parent_id = parentId();
                $reminder->save();

                if (($trainee->traineeDetail->communication_preference == 'sms' || $trainee->traineeDetail->communication_preference == 'both') && $notification->enabled_sms == 1) {
                    $this->scheduleTwilioSms($reminder, $trainee, $notification, $settings);
                }
            }
        }
    }

    private function scheduleTwilioSms($reminder, $trainee, $notification, $settings)
    {
        $sid = $settings['twilio_sid'];
        $token = $settings['twilio_token'];
        $from = $settings['twilio_messaging_service_sid'] ?? $settings['twilio_from'];
        
        if (empty($sid) || empty($token) || empty($from)) return;

        $body = MessageReplace($notification, $trainee->id)['message']; // Note: MessageReplace might need to handle sms_message specifically
        // For now using the existing MessageReplace or adding a new one for SMS
        if (!empty($notification->sms_message)) {
            $body = str_replace(['{name}', '{expiry_date}'], [$trainee->name, $trainee->traineeDetail->membership_expiry_date], $notification->sms_message);
        }

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', "https://api.twilio.com/2010-04-01/Accounts/$sid/Messages.json", [
                'auth' => [$sid, $token],
                'form_params' => [
                    'To' => $trainee->phone_number,
                    'From' => $from,
                    'Body' => $body,
                    'SendAt' => $reminder->scheduled_at->toIso8601String(),
                    'ScheduleType' => 'fixed',
                ]
            ]);

            $responseData = json_decode($response->getBody(), true);
            if (isset($responseData['sid'])) {
                $reminder->external_schedule_id = $responseData['sid'];
                $reminder->save();
            }
        } catch (\Exception $e) {
            \Log::error('Twilio Scheduling Error: ' . $e->getMessage());
        }
    }

    private function cancelReminders($userId)
    {
        $reminders = Reminder::where('trainee_id', $userId)->where('status', 'pending')->get();
        $settings = settings();
        $sid = $settings['twilio_sid'];
        $token = $settings['twilio_token'];

        foreach ($reminders as $reminder) {
            if ($reminder->external_schedule_id && $sid && $token) {
                try {
                    $client = new \GuzzleHttp\Client();
                    $client->request('POST', "https://api.twilio.com/2010-04-01/Accounts/$sid/Messages/{$reminder->external_schedule_id}.json", [
                        'auth' => [$sid, $token],
                        'form_params' => [
                            'Status' => 'canceled',
                        ]
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Twilio Cancellation Error: ' . $e->getMessage());
                }
            }
            $reminder->status = 'canceled';
            $reminder->save();
        }
    }

    public function sendReminder($id)
    {
        $id = decrypt($id);
        $trainee = User::with('traineeDetail')->find($id);
        if (!$trainee || !$trainee->traineeDetail) {
            return redirect()->back()->with('error', __('Trainee not found.'));
        }

        $notification = Notification::where('parent_id', parentId())->where('module', 'membership_expiry_reminder')->first();
        if (!$notification || $notification->enabled_sms != 1) {
            return redirect()->back()->with('error', __('SMS reminder is not enabled or template not found.'));
        }

        $settings = settings();
        
        $reminder = new Reminder();
        $reminder->trainee_id = $trainee->id;
        $reminder->type = 'manual_reminder';
        $reminder->scheduled_at = now();
        $reminder->status = 'sent';
        $reminder->parent_id = parentId();
        
        $sid = $settings['twilio_sid'];
        $token = $settings['twilio_token'];
        $from = $settings['twilio_messaging_service_sid'] ?? $settings['twilio_from'];
        
        if (empty($sid) || empty($token) || empty($from)) {
            return redirect()->back()->with('error', __('Twilio settings missing.'));
        }

        $body = !empty($notification->sms_message) 
            ? str_replace(['{name}', '{expiry_date}'], [$trainee->name, $trainee->traineeDetail->membership_expiry_date], $notification->sms_message)
            : MessageReplace($notification, $trainee->id)['message'];

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', "https://api.twilio.com/2010-04-01/Accounts/$sid/Messages.json", [
                'auth' => [$sid, $token],
                'form_params' => [
                    'To' => $trainee->phone_number,
                    'From' => $from,
                    'Body' => $body,
                ]
            ]);

            $responseData = json_decode($response->getBody(), true);
            $reminder->external_schedule_id = $responseData['sid'] ?? null;
            $reminder->sent_at = now();
            $reminder->save();

            return redirect()->back()->with('success', __('Reminder sent successfully via Twilio.'));
        } catch (\Exception $e) {
            \Log::error('Twilio Manual Send Error: ' . $e->getMessage());
            $reminder->status = 'failed';
            $reminder->response_log = $e->getMessage();
            $reminder->save();
            return redirect()->back()->with('error', __('Failed to send reminder: ') . $e->getMessage());
        }
    }
}
