<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'package',
        'amount',
        'classes_id',
        'parent_id',
        'notes',
    ];

    public static $package=[
        'monthly'=>'Monthly',
        'quarterly'=>'Quarterly',
        'half_yearly'=>'Half Yearly',
        'yearly'=>'Yearly',
        'lifetime'=>'Lifetime',
    ];

    public function claases()
    {
        $classes_id=!empty($this->classes_id)?explode(',',$this->classes_id):[];
        return Classes::whereIn('id',$classes_id)->get();
    }

    public static function calculateExpiryDate($startDate, $id)
    {

        $memberShip=Membership::find($id);

        $duration=$memberShip->package;
        // Create a DateTime object from the start date
        $startDate = new \DateTime($startDate);

        // Add the specified duration to the start date
        switch ($duration) {
            case 'monthly':
                $expiryDate = $startDate->modify('+1 month');
                break;
            case 'quarterly':
                $expiryDate = $startDate->modify('+3 months');
                break;
            case 'half_yearly':
                $expiryDate = $startDate->modify('+6 months');
                break;
            case 'yearly':
                $expiryDate = $startDate->modify('+1 year');
                break;
            default:
                $expiryDate=null;
        }

        // Format the expiry date as a string
        return !empty($expiryDate)?$expiryDate->format('Y-m-d'):null;
    }

}
