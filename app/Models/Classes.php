<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'fees',
        'address',
        'notes',
        'parent_id',
    ];

    public static $days = [
        'Sunday' => 'Sunday',
        'Monday' => 'Monday',
        'Tuesday' => 'Tuesday',
        'Wednesday' => 'Wednesday',
        'Thursday' => 'Thursday',
        'Friday' => 'Friday',
        'Saturday' => 'Saturday',
    ];

    public function classSchedule()
    {
        return $this->hasMany(ClassSchedule::class);
    }
    public function classAssignTrainer()
    {
        return $this->hasMany(ClassAssign::class)->where('assign_type',  'trainer');
    }
    public function classAssignTrainee()
    {
        return $this->hasMany(ClassAssign::class)->where('assign_type',  'trainee');
    }


}
