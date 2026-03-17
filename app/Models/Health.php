<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Health extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'measurement_date',
        'result',
        'notes',
        'parent_id',
    ];

    public static $measurement_type=[
        'Height'=>'Height',
        'Weight'=>'Weight',
        'Waist'=>'Waist',
        'Chest'=>'Chest',
        'Thigh'=>'Thigh',
        'Arms'=>'Arms',
        'Fat'=>'Fat',
    ];

    public function users()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
