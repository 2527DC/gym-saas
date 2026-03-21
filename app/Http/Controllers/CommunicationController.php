<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommunicationController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('view reminder logs')) {
            $reminders = Reminder::where('parent_id', parentId())->with('trainee')->orderBy('id', 'desc')->get();
            return view('communication.index', compact('reminders'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function settings(Request $request)
    {
        if (\Auth::user()->can('manage sms settings')) {
            $settings = [
                'twilio_sid' => $request->twilio_sid,
                'twilio_token' => $request->twilio_token,
                'twilio_from' => $request->twilio_from,
                'twilio_messaging_service_sid' => $request->twilio_messaging_service_sid,
                'reminder_auto_schedule_days' => $request->reminder_auto_schedule_days,
            ];

            foreach ($settings as $key => $val) {
                DB::insert(
                    'insert into settings (`value`, `name`, `type`, `parent_id`) values (?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                    [
                        $val ?? '',
                        $key,
                        'sms',
                        parentId(),
                    ]
                );
            }

            return redirect()->back()->with('success', __('SMS settings successfully updated.'))->with('tab', 'sms_settings');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'))->with('tab', 'sms_settings');
        }
    }

    public function testSms()
    {
        return view('settings.test_sms');
    }

    public function sendTestSms(Request $request)
    {
        if (\Auth::user()->can('manage sms settings')) {
            $to = $request->test_phone_number;
            if (!str_starts_with($to, '+')) {
                $to = '+' . $to;
            }
            Log::info('Test SMS Initiated', ['to' => $to]);
            
            $validator = \Validator::make($request->all(), [
                'test_phone_number' => 'required',
            ]);

            if ($validator->fails()) {
                Log::warning('Test SMS Validation Failed', ['errors' => $validator->errors()->all()]);
                return redirect()->back()->with('error', $validator->errors()->first())->with('tab', 'sms_settings');
            }

            $settings = settings();
            $sid = $settings['twilio_sid'];
            $token = $settings['twilio_token'];
            $from = !empty($settings['twilio_messaging_service_sid']) ? $settings['twilio_messaging_service_sid'] : $settings['twilio_from'];

            Log::debug('Twilio Configuration Loaded', [
                'sid' => substr($sid, 0, 4) . '...',
                'from' => $from
            ]);

            if ($sid && $token && $from) {
                try {
                    $client = new \GuzzleHttp\Client();
                    $response = $client->request('POST', "https://api.twilio.com/2010-04-01/Accounts/$sid/Messages.json", [
                        'auth' => [$sid, $token],
                        'form_params' => [
                            'From' => $from,
                            'To' => $to,
                            'Body' => $request->test_message ?? __('Test SMS from Gym Management System'),
                        ]
                    ]);

                    $body = $response->getBody()->getContents();
                    Log::info('Twilio API Response Received', ['body' => $body]);
                    $res = json_decode($body, true);
                    
                    if (isset($res['sid'])) {
                        Log::info('Test SMS Sent Successfully', ['sid' => $res['sid']]);
                        return redirect()->back()->with('success', __('Test SMS sent successfully.'))->with('tab', 'sms_settings');
                    } else {
                        Log::error('Twilio Response missing SID', ['res' => $res]);
                        return redirect()->back()->with('error', __('Failed to send Test SMS. Check your credentials.'))->with('tab', 'sms_settings');
                    }
                } catch (\Exception $e) {
                    $errorMessage = $e->getMessage();
                    if ($e instanceof \GuzzleHttp\Exception\ClientException && $e->hasResponse()) {
                        $responseBody = $e->getResponse()->getBody()->getContents();
                        $decodedBody = json_decode($responseBody, true);
                        if (isset($decodedBody['message'])) {
                            $errorMessage = $decodedBody['message'];
                        }
                    }

                    Log::error('Twilio Error during Test SMS', [
                        'message' => $e->getMessage(),
                        'parsed_message' => $errorMessage,
                        'trace' => $e->getTraceAsString()
                    ]);
                    return redirect()->back()->with('error', __('Twilio Error: ') . $errorMessage)->with('tab', 'sms_settings');
                }
            } else {
                Log::warning('Test SMS Aborted: Missing Credentials', [
                    'sid_exists' => !empty($sid),
                    'token_exists' => !empty($token),
                    'from_exists' => !empty($from)
                ]);
                return redirect()->back()->with('error', __('Twilio credentials or From number are missing.'))->with('tab', 'sms_settings');
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'))->with('tab', 'sms_settings');
        }
    }
}
