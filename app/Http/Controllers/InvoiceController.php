<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use App\Models\Notification;
use App\Models\Type;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\TraineeDetail;

class InvoiceController extends Controller
{

    public function index()
    {
        if (Auth::user()->can('manage invoice')) {
            if (Auth::user()->type == 'trainer') {
                $assignTrainee = TraineeDetail::where('trainer_assign', Auth::user()->id)->get()->pluck('user_id')->toArray();
                $invoices = Invoice::whereIn('user_id', $assignTrainee)->orderBy('id', 'desc')->get();
            } elseif(Auth::user()->type == 'trainee') {
                $invoices = Invoice::where('parent_id', parentId())->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
            } else {
                $invoices = Invoice::where('parent_id', parentId())->orderBy('id', 'desc')->get();
            }
            return view('invoice.index', compact('invoices'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function create()
    {
        if (Auth::user()->can('create invoice')) {
            $trainee = User::where('parent_id', parentId())->where('type', 'trainee')->get()->pluck('name', 'id');
            $trainee->prepend(__('Select Trainee'), '');

            $invoiceNumber = $this->invoiceNumber();

            $types = Type::where('parent_id', parentId())->where('type', 'invoice')->get()->pluck('title', 'id');
            $types->prepend(__('Select Type'), '');

            return view('invoice.create', compact('trainee', 'invoiceNumber', 'types'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function store(Request $request)
    {

        if (Auth::user()->can('create invoice')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    'invoice_id' => 'required',
                    'invoice_date' => 'required',
                    'invoice_due_date' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $invoice = new Invoice();
            $invoice->invoice_id = $request->invoice_id;
            $invoice->user_id = $request->user_id;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->invoice_due_date = $request->invoice_due_date;
            $invoice->status = 'unpaid';
            $invoice->parent_id = parentId();
            $invoice->save();
            $types = $request->types;

            for ($i = 0; $i < count($types); $i++) {
                $invoiceItem = new InvoiceItem();
                $invoiceItem->invoice_id = $invoice->id;
                $invoiceItem->type_id = $types[$i]['type_id'];
                $invoiceItem->title = $types[$i]['title'];
                $invoiceItem->amount = $types[$i]['amount'];
                $invoiceItem->description = $types[$i]['description'];
                $invoiceItem->save();
            }

            $module = 'invoice_create';
            $notification = Notification::where('parent_id', parentId())->where('module', $module)->first();
            $setting = settings();
            $errorMessage = '';

            if (!empty($notification) && $notification->enabled_email == 1) {
                $notificationResponse = MessageReplace($notification, $invoice->id);

                $data['subject'] = $notificationResponse['subject'];
                $data['message'] = $notificationResponse['message'];
                $data['module'] = $module;
                $data['logo'] = $setting['company_logo'];
                $to = $invoice->users->email;

                $response = commonEmailSend($to, $data);

                if ($response['status'] == 'error') {
                    $errorMessage = $response['message'];
                }
            }



            return redirect()->route('invoices.index')->with('success', __('Invoice successfully created.') . '</br>' . $errorMessage);
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function show($id)
    {
        if (Auth::user()->can('show invoice')) {
            $invoice = Invoice::find(Crypt::decrypt($id));
            $invoiceNumber = $invoice->invoice_id;

            return view('invoice.show', compact('invoiceNumber', 'invoice'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function edit($ids)
    {
        $invoice = Invoice::find(Crypt::decrypt($ids));

        if (Auth::user()->can('edit invoice')) {
            $trainee = User::where('parent_id', parentId())->where('type', 'trainee')->get()->pluck('name', 'id');
            $trainee->prepend(__('Select Trainee'), '');
            $types = Type::where('parent_id', parentId())->where('type', 'invoice')->get()->pluck('title', 'id');
            $types->prepend(__('Select Type'), '');
            $invoiceNumber = $invoice->invoice_id;
            return view('invoice.edit', compact('trainee', 'invoice', 'types', 'invoiceNumber'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function update(Request $request, Invoice $invoice)
    {
        if (Auth::user()->can('create invoice')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'user_id' => 'required',
                    'invoice_date' => 'required',
                    'invoice_due_date' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $invoice->user_id = $request->user_id;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->invoice_due_date = $request->invoice_due_date;
            $invoice->save();
            $types = $request->types;

            for ($i = 0; $i < count($types); $i++) {
                $invoiceItem = InvoiceItem::find($types[$i]['id']);
                if ($invoiceItem == null) {
                    $invoiceItem = new InvoiceItem();
                    $invoiceItem->invoice_id = $invoice->id;
                }

                $invoiceItem->type_id = $types[$i]['type_id'];
                $invoiceItem->title = $types[$i]['title'];
                $invoiceItem->amount = $types[$i]['amount'];
                $invoiceItem->description = $types[$i]['description'];
                $invoiceItem->save();
            }

            return redirect()->route('invoices.index')->with('success', __('Invoice successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function destroy($id)
    {
        if (Auth::user()->can('delete invoice')) {
            $id = decrypt($id);
            $invoice = Invoice::find($id);
            InvoiceItem::where('invoice_id', $invoice->id)->delete();
            InvoicePayment::where('invoice_id', $invoice->id)->delete();
            $invoice->delete();
            return redirect()->route('invoices.index')->with('success', __('Invoice successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function invoiceNumber()
    {
        $latest = Invoice::where('parent_id', parentId())->latest()->first();
        if ($latest == null) {
            return 1;
        } else {
            return $latest->invoice_id + 1;
        }
    }

    public function invoiceTypeDestroy(Request $request)
    {

        if (Auth::user()->can('delete invoice type')) {
            $invoiceType = InvoiceItem::find($request->id);
            $invoiceType->delete();

            return response()->json([
                'status' => 'success',
                'msg' => __('Invoice type successfully updated.'),
            ]);
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function invoicePaymentCreate($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);

        return view('invoice.payment', compact('invoice_id', 'invoice'));
    }

    public function invoicePaymentStore(Request $request, $invoice_id)
    {
        if (Auth::user()->can('create invoice payment')) {
            $invoice = Invoice::find($invoice_id);
            $dueAmount = $invoice->getInvoiceTotalDueAmount();
            $validator = \Validator::make(
                $request->all(),
                [
                    'payment_date' => 'required',
                    'amount' => 'required|numeric|min:1|max:' . $dueAmount,
                ],

            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            if (!empty($request->receipt)) {
                $receiptFilenameWithExt = $request->file('receipt')->getClientOriginalName();
                $receiptFilename = pathinfo($receiptFilenameWithExt, PATHINFO_FILENAME);
                $receiptExtension = $request->file('receipt')->getClientOriginalExtension();
                $receiptFileName = $receiptFilename . '_' . time() . '.' . $receiptExtension;
                $dir = storage_path('upload/receipt');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $request->file('receipt')->storeAs('upload/receipt/', $receiptFileName);

            }

            $payment = new InvoicePayment();
            $payment->invoice_id = $invoice_id;
            $payment->transaction_id = md5(time());
            $payment->payment_type = __('Manually');
            $payment->amount = $request->amount;
            $payment->payment_date = $request->payment_date;
            $payment->receipt = !empty($request->receipt) ? $receiptFileName : '';
            $payment->notes = $request->notes;
            $payment->parent_id = parentId();
            $payment->save();
            $invoice = Invoice::find($invoice_id);
            if ($invoice->getInvoiceTotalDueAmount() <= 0) {
                $status = 'paid';
            } else {
                $status = 'partial_paid';
            }
            Invoice::statusChange($invoice->id, $status);
            return redirect()->back()->with('success', __('Invoice payment successfully added.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

    }

    public function invoicePaymentDestroy($invoice_id, $id)
    {
        if (Auth::user()->can('delete invoice payment')) {
            $payment = InvoicePayment::find($id);
            $payment->delete();

            $invoice = Invoice::find($invoice_id);
            if ($invoice->getInvoiceTotalDueAmount() <= 0) {
                $status = 'paid';
            } elseif ($invoice->getInvoiceTotalDueAmount() == $invoice->getInvoiceSubTotalAmount()) {
                $status = 'unpaid';
            } else {
                $status = 'partial_paid';
            }
            Invoice::statusChange($invoice->id, $status);
            return redirect()->back()->with('success', __('Invoice payment successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }
}
