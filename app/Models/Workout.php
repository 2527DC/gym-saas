<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;
    protected $fillable=[
        'assign_to',
        'assign_id',
        'start_date',
        'end_date',
        'workout_history',
        'notes',
        'parent_id',
    ];

    public function assignDetail()
    {
        if($this->assign_to=='trainee'){
            return $this->hasOne('App\Models\User','id','assign_id');
        }else{
            return $this->hasOne('App\Models\Classes','id','assign_id');
        }

    }

    public static function activities($id)
    {
        $actitivy=WorkoutActivity::find($id);
        return !empty($actitivy)?$actitivy->title:'';
    }
}
