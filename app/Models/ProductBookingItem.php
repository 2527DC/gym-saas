<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBookingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_booking_id',
        'quantity',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
