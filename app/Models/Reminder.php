<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainee_id',
        'type',
        'scheduled_at',
        'sent_at',
        'status',
        'response_log',
        'external_schedule_id',
        'parent_id',
    ];

    public function trainee()
    {
        return $this->belongsTo(User::class, 'trainee_id');
    }
}
