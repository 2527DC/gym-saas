<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable=[
        'invoice_id',
        'user_id',
        'invoice_date',
        'invoice_due_date',
        'status',
        'notes',
        'parent_id',
    ];

    public static $status = [
        'unpaid' => 'Unpaid',
        'paid' => 'Paid',
        'partial_paid' => 'Partial Paid',
    ];

    public function users()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function types()
    {
        return $this->hasMany('App\Models\InvoiceItem', 'invoice_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\InvoicePayment', 'invoice_id', 'id');
    }

    public function getInvoiceSubTotalAmount()
    {
        $invoiceSubTotal = 0;
        foreach ($this->types as $invoiceType) {
            $invoiceSubTotal += $invoiceType->amount;
        }
        return $invoiceSubTotal;
    }

    public function getInvoiceTotalDueAmount()
    {
        $invoiceDueAmount = 0;
        foreach ($this->payments as $invoicePayment) {
            $invoiceDueAmount += $invoicePayment->amount;
        }
        return $this->getInvoiceSubTotalAmount() - $invoiceDueAmount;
    }

    public static function statusChange($invoice_id, $status)
    {
        $invoice = Invoice::find($invoice_id);
        $invoice->status = $status;
        $invoice->save();
        return $invoice;
    }
}
