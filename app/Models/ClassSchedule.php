<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use HasFactory;
    protected $fillable=[
        'classes_id',
        'days',
        'start_time',
        'end_time',
        'parent_id',
    ];
}
