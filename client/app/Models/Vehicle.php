<?php

namespace App\Models;

use App\Functions\Core;
use App\Traits\HasCache;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Vehicle extends Model
{
    use HasFactory, HasSearch, HasCache;

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

        'loan_amount',
        'monthly_installment',
        'loan_issued_at',

        'paid_period',
        'due_period',
        'paid_amount',
        'due_amount',

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

        'loan_amount',
        'monthly_installment',
        'loan_issued_at',
        'paid_period',
        'due_period',
        'paid_amount',
        'due_amount',
    ];

    protected static function booted()
    {
        self::saving(function ($Self) {
            if (is_null($Self->company)) {
                $Self->company = Core::company('id');
            }
        });

        self::saved(function ($Self) {
            Vehicle::delCache(
                tags: ['many'],
                keys: ['company_' . Core::company('id') . '_vehicles_solo_' . $Self->id],
            );
        });

        self::deleted(function ($Self) {
            $Self->Notifications()->delete();
            Vehicle::delCache(
                tags: ['many'],
                keys: ['company_' . Core::company('id') . '_vehicles_solo_' . $Self->id],
            );
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

    public function Notifications(): MorphMany
    {
        return $this->MorphMany(Notification::class, 'target');
    }
}
