<?php

namespace App\Models;

use App\Functions\Core;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory, HasSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'registration_type',
        'registration_number',
        'brand',
        'model',
        'year',
        'daily_rate',

        'passenger_capacity',
        'mileage',
        'number_of_doors',
        'cargo_capacity',
        'transmission_type',
        'fuel_type',

        'registration_date',
        'horsepower',
        'horsepower_tax',
        'insurance_company',
        'insurance_issued_at',
        'insurance_cost',

        'company',
    ];

    protected $searchable = [
        'registration_type',
        'registration_number',
        'brand',
        'model',
        'year',
        'daily_rate',

        'passenger_capacity',
        'mileage',
        'number_of_doors',
        'cargo_capacity',
        'transmission_type',
        'fuel_type',

        'registration_date',
        'horsepower',
        'horsepower_tax',
        'insurance_company',
        'insurance_issued_at',
        'insurance_cost',
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


    public function Reservations()
    {
        return $this->hasMany(Reservation::class, 'vehicle');
    }

    public function Charges()
    {
        return $this->hasMany(Charge::class, 'vehicle');
    }

    public function Reminders()
    {
        return $this->hasMany(Reminder::class, 'vehicle');
    }
}
