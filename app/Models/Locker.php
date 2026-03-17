<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'parent_id',
        'avialable',
    ];

    public static $status = [
        0 => 'Inactive',
        1 => 'Active',
    ];

    public static $available = [
        0 => 'Not Availbale',
        1 => 'Available'
    ];

    public static $statusBadge = [
        1 => 'success',
        0 => 'danger',
    ];
    public static $availableBadge = [
        1 => 'success',
        0 => 'danger',
    ];

    public function getStatusBadgeHtmlAttribute()
    {
        $label = self::$status[$this->status] ?? 'Unknown';
        $class = self::$statusBadge[$this->status] ?? 'secondary';

        return '<span class="badge bg-' . $class . '">' . $label . '</span>';
    }

    public function getAvailableBadgeHtmlAttribute()
    {
        $label = self::$available[$this->available] ?? 'Unknown';
        $class = self::$availableBadge[$this->available] ?? 'secondary';

        return '<span class="badge bg-' . $class . '">' . $label . '</span>';
    }
}
