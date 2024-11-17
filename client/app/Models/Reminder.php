<?php

namespace App\Models;

use App\Functions\Core;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Reminder extends Model
{
    use HasFactory, HasSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vehicle',

        'consumable_name',
        'recurrence_amount',
        'unit_of_measurement',
        'threshold_value',
        'reminder_date',
        'view_issued_at',

        'company',
    ];

    protected $searchable = [
        'vehicle.registration_number',
        'vehicle.brand',
        'vehicle.model',
        'vehicle.year',

        'consumable_name',
        'recurrence_amount',
        'unit_of_measurement',
        'threshold_value',
        'reminder_date',
        'last_viewed_at',
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

    public function Vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle');
    }

    public function Notifications(): MorphMany
    {
        return $this->MorphMany(Notification::class, 'target');
    }
}
