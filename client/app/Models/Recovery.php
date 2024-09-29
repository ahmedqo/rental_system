<?php

namespace App\Models;

use App\Functions\Core;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recovery extends Model
{
    use HasFactory, HasSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reservation',

        'mileage',
        'fuel_level',
        'condition',
        'penalties',
        'status',

        'company',
    ];

    protected $searchable = [
        'reservation.reference',
        'reservation.pickup_date',
        'reservation.pickup_location',
        'reservation.dropoff_date',
        'reservation.dropoff_location',

        'mileage',
        'fuel_level',
        'status',
    ];

    protected static function booted()
    {
        self::saving(function ($Self) {
            if (is_null($Self->company)) {
                $Self->company = Core::company('id');
            }
        });
    }

    public function Owner()
    {
        return $this->belongsTo(Company::class, 'company');
    }

    public function Reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation');
    }
}
