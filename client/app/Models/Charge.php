<?php

namespace App\Models;

use App\Functions\Core;
use App\Traits\HasCache;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory, HasSearch, HasCache;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vehicle',
        'name',
        'details',
        'cost',

        'company',
    ];

    protected $searchable = [
        'vehicle.registration_number',
        'vehicle.brand',
        'vehicle.model',
        'vehicle.year',

        'name',
        'details',
        'cost'
    ];

    protected static function booted()
    {
        self::saving(function ($Self) {
            if (is_null($Self->company)) {
                $Self->company = Core::company('id');
            }
        });

        self::saved(function ($Self) {
            Charge::delCache(
                tags: ['many'],
                keys: ['company_' . Core::company('id') . '_charges_solo_' . $Self->id],
            );
        });

        self::deleted(function ($Self) {
            Charge::delCache(
                tags: ['many'],
                keys: ['company_' . Core::company('id') . '_charges_solo_' . $Self->id],
            );
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
}
