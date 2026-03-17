<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'date',
        'checked_in_time',
        'checked_out_time',
        'parent_id',
        'notes',
    ];

    public function users()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
