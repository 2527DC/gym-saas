<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\ProductBooking;
use App\Models\ProductBookingItem;
use App\Models\Type;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ProductBookingController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('manage product booking')) {
            $productBookings = ProductBooking::with(['user', 'items.product'])->where('parent_id', parentId())->get();
            return view('product_booking.index', compact('productBookings'));
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }

    public function create()
    {
        $trainees = User::where('parent_id', parentId())->where('type', 'trainee')->get()->pluck('name', 'id');
        $products = Product::where('parent_id', parentId())->pluck('title', 'id');
        return view('product_booking.create', compact('trainees', 'products'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create product booking')) {

            DB::beginTransaction();

            try {
                $productBooking = new ProductBooking();
                $productBooking->user_id = $request->user_id;
                $productBooking->parent_id = parentId();
                $productBooking->invoice_date = Carbon::parse($request->invoice_date);
                $productBooking->price = $request->input('grand_total'); // Optional
                $productBooking->save();

                foreach ($request->product_id as $index => $productId) {
                    ProductBookingItem::create([
                        'product_booking_id' => $productBooking->id,
                        'product_id' => $productId,
                        'quantity' => $request->quantity[$index] ?? 1,
                    ]);
                }

                $lastInvoiceId = Invoice::orderBy('invoice_id', 'desc')->value('invoice_id');
                $nextInvoiceId = $lastInvoiceId ? ((int) $lastInvoiceId + 1) : 1;

                $invoice = new Invoice();
                $invoice->invoice_id = $nextInvoiceId;
                $invoice->user_id = $request->user_id;
                $invoice->invoice_date = Carbon::parse($request->invoice_date);
                $invoice->invoice_due_date = Carbon::parse($request->invoice_date)->addDays(7);
                $invoice->status = 'unpaid';
                $invoice->parent_id = parentId();
                $invoice->save();

                $productBookingId = Type::where('title', 'Product')->where('parent_id', parentId())->first();

                $invoiceItem = new InvoiceItem();
                $invoiceItem->invoice_id = $invoice->id;
                $invoiceItem->type_id = $productBookingId->id;
                $invoiceItem->title = 'Product Booking';
                $invoiceItem->description = 'Invoice for product booking';
                $invoiceItem->amount = $request->input('grand_total');
                $invoiceItem->save();

                DB::commit();

                return redirect()->route('product-booking.index')->with('success', 'Product Booking & Invoice created successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Error: ' . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Permisisond denied');
        }
    }

    public function show(ProductBooking $productBooking)
    {
        //
    }

    public function edit(ProductBooking $productBooking)
    {
        //
    }

    public function update(Request $request, ProductBooking $productBooking)
    {
        //
    }

    public function destroy($id)
    {
        if (Auth::user()->can('delete product booking')) {
            $productBooking = ProductBooking::find(decrypt($id));

            if ($productBooking) {
                ProductBookingItem::where('product_booking_id', $productBooking->id)->delete();
                $productBooking->delete();
            }

            return redirect()->back()->with('success', 'Product booking deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }

    public function productDetail($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }
}
