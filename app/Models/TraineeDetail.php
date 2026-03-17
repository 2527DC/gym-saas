<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeDetail extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'trainee_id',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'dob',
        'age',
        'fitness_goal',
        'membership_plan',
        'trainer_assign',
        'membership_start_date',
        'membership_expiry_date',
        'gender',
        'assign_class',
        'document',
        'category',
        'status',
        'parent_id',
    ];

    public static $status = [
        1=>'Active',
        0=> 'Inactive',
    ];

    public function categorys()
    {
        return $this->hasOne('App\Models\Category','id','category');
    }

    public function membership()
    {
        return $this->hasOne('App\Models\Membership','id','membership_plan');
    }

    public function userDetail()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function trainers()
    {
        return $this->hasOne('App\Models\User','id','trainer_assign');
    }
}
