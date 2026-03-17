<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignLocker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assign_date',
        'end_date'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
