<?php

namespace App\Models;

use App\Functions\Core;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, HasSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reservation',

        'daily_rate',
        'total',
        'paid',
        'rest',

        'logs',
        'status',

        'company',
    ];

    protected $searchable = [
        'reservation.reference',
        'reservation.pickup_date',
        'reservation.pickup_location',
        'reservation.dropoff_date',
        'reservation.dropoff_location',

        'reservation.client.identity_number',
        'reservation.client.license_number',
        'reservation.client.first_name',
        'reservation.client.last_name',
        'reservation.client.email',
        'reservation.client.phone',

        'reservation.sclient.identity_number',
        'reservation.sclient.license_number',
        'reservation.sclient.first_name',
        'reservation.sclient.last_name',
        'reservation.sclient.email',
        'reservation.sclient.phone',

        'reservation.agency.name',
        'reservation.agency.phone',
        'reservation.agency.email',

        'reservation.vehicle.registration_number',
        'reservation.vehicle.brand',
        'reservation.vehicle.model',
        'reservation.vehicle.year',

        'daily_rate',
        'total',
        'paid',
        'rest',
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
