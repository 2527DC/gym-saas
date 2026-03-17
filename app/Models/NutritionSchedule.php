<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'user_id',
        'start_date',
        'end_date',
        'schedules'
    ];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}


