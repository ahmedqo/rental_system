<?php

namespace App\Models;

use App\Functions\Core;
use App\Traits\HasSearch;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory, HasSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vehicle',
        'agency',
        'client',
        'secondary_client',

        'reference',
        'pickup_date',
        'pickup_location',
        'dropoff_date',
        'dropoff_location',
        'rental_period_days',
        'mileage',
        'fuel_level',
        'condition',
        'status',

        'company',
    ];

    protected $searchable = [
        'client.identity_number',
        'client.license_number',
        'client.first_name',
        'client.last_name',
        'client.email',
        'client.phone',

        'sclient.identity_number',
        'sclient.license_number',
        'sclient.first_name',
        'sclient.last_name',
        'sclient.email',
        'sclient.phone',

        'agency.name',
        'agency.phone',
        'agency.email',

        'vehicle.registration_number',
        'vehicle.brand',
        'vehicle.model',
        'vehicle.year',

        'reference',
        'pickup_date',
        'pickup_location',
        'dropoff_date',
        'dropoff_location',
        'rental_period_days',
        'mileage',
        'fuel_level',
        'condition',
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

    public function Client()
    {
        return $this->belongsTo(Client::class, 'client');
    }

    public function SClient()
    {
        return $this->belongsTo(Client::class, 'secondary_client');
    }

    public function Agency()
    {
        return $this->belongsTo(Agency::class, 'agency');
    }

    public function Vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle');
    }

    public function Payment()
    {
        return $this->hasOne(Payment::class, 'reservation');
    }

    public function Recovery()
    {
        return $this->hasOne(Recovery::class, 'reservation');
    }
}
