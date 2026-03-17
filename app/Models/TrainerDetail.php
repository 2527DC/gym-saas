<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerDetail extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'trainer_id',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'dob',
        'gender',
        'qualification',
        'document',
        'status',
        'parent_id',
    ];

    public static $status = [
        1=>'Active',
        0=> 'Inactive',
    ];

}
