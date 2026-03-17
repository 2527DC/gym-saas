<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassAssign extends Model
{
    use HasFactory;

    protected $fillable = [
        'classes_id',
        'assign_id',
        'assign_type',
    ];

    public function userDetail()
    {
        return $this->hasOne('App\Models\User', 'id', 'assign_id');
    }

}
