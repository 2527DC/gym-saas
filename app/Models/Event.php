<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'event_type_id',
        'start_date',
        'end_date',
        'title',
        'description',
        'status'
    ];

    public static function status()
    {
        return [
            1 => __('Scheduled'),
            2 => __('Ongoing'),
            3 => __('Completed'),
            4 => __('Cancelled'),
        ];
    }

    public function eventType() {
         return $this->hasOne(EventType::class, 'id', 'event_type_id');
    }
}
