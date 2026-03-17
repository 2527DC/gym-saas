<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Contact;
use App\Models\Custom;
use App\Models\Expense;
use App\Models\FAQ;
use App\Models\HomePage;
use App\Models\InvoicePayment;
use App\Models\NoticeBoard;
use App\Models\PackageTransaction;
use App\Models\Page;
use App\Models\Subscription;
use App\Models\Support;
use App\Models\TraineeDetail;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        if (\Auth::check()) {
            if (\Auth::user()->type == 'super admin') {
                $result['totalOrganization'] = User::where('type', 'owner')->count();
                $result['totalSubscription'] = Subscription::count();
                $result['totalTransaction'] = PackageTransaction::count();
                $result['totalIncome'] = PackageTransaction::sum('amount');
                $result['totalNote'] = NoticeBoard::where('parent_id', parentId())->count();
                $result['totalContact'] = Contact::where('parent_id', parentId())->count();

                $result['organizationByMonth'] = $this->organizationByMonth();
                $result['paymentByMonth'] = $this->paymentByMonth();

                return view('dashboard.super_admin', compact('result'));
            } elseif (\Auth::user()->type == 'trainer') {

                $result['totalTrainee'] = TraineeDetail::where('trainer_assign', \Auth::user()->id)->count();
                $result['totalClass'] = Classes::where('parent_id', parentId())->count();
                $result['totalNote'] = NoticeBoard::where('parent_id', \Auth::user()->id)->count();
                $result['totalContact'] = Contact::where('parent_id', \Auth::user()->id)->count();
                return view('dashboard.trainer', compact('result'));
            } elseif (\Auth::user()->type == 'trainee') {
                $traineeDetail = \Auth::user()->traineeDetail;

                $result['assignTrainer'] = !empty($traineeDetail) ? User::find($traineeDetail->trainer_assign)->name : '';

                $result['totalClass'] = Classes::where('parent_id', parentId())->count();
                $result['totalNote'] = NoticeBoard::where('parent_id', \Auth::user()->id)->count();
                $result['totalContact'] = Contact::where('parent_id', \Auth::user()->id)->count();
                return view('dashboard.trainee', compact('result'));
            } else {
                $result['totalTrainer'] = User::where('parent_id', parentId())->where('type', 'trainer')->count();
                $result['totalTrainee'] = User::where('parent_id', parentId())->where('type', 'trainee')->count();
                $result['todayIncome'] = InvoicePayment::where('parent_id', parentId())->where('payment_date', date('Y-m-d'))->sum('amount');
                $result['todayExpense'] = Expense::where('date', date('Y-m-d'))->sum('amount');

                // Fetch monthly data
                $result['organizationByMonth'] = $this->incomeByMonth();
                $result['paymentByMonth'] = $this->paymentByMonth();

                return view('dashboard.index', compact('result'));
                $result['settings'] = settings();
                $result['incomeExpenseByMonth'] = $this->incomeByMonth();
                return view('dashboard.index', compact('result'));
            }
        } else {
            if (!file_exists(setup())) {
                header('location:install');
                die;
            } else {

                $landingPage = getSettingsValByName('landing_page');
                if ($landingPage == 'on') {
                    $subscriptions = Subscription::get();
                    $menus = Page::where('enabled', 1)->get();
                    $FAQs = FAQ::where('enabled', 1)->get();
                    return view('layouts.landing', compact('subscriptions', 'menus', 'FAQs'));
                } else {
                    return redirect()->route('login');
                }
            }

        }

    }

    public function organizationByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));

        $currentdate = $start;

        $organization = [];
        while ($currentdate <= $end) {
            $organization['label'][] = date('M-Y', $currentdate);

            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $organization['data'][] = User::where('type', 'owner')->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
            $currentdate = strtotime('+1 month', $currentdate);
        }


        return $organization;

    }

    public function paymentByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));

        $currentdate = $start;

        $payment = [];
        while ($currentdate <= $end) {
            $payment['label'][] = date('M-Y', $currentdate);

            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $payment['data'][] = PackageTransaction::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('amount');
            $currentdate = strtotime('+1 month', $currentdate);
        }

        return $payment;

    }

    public function incomeByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));

        $currentdate = $start;

        $payment = [];
        while ($currentdate <= $end) {
            $payment['label'][] = date('M-Y', $currentdate);

            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $payment['income'][] = InvoicePayment::where('parent_id', parentId())->whereMonth('payment_date', $month)->whereYear('payment_date', $year)->sum('amount');
            $payment['expense'][] = Expense::where('parent_id', parentId())->whereMonth('date', $month)->whereYear('date', $year)->sum('amount');
            $currentdate = strtotime('+1 month', $currentdate);
        }

        return $payment;

    }

}
