<?php

namespace App\Models;

use App\Functions\Core;
use App\Traits\HasCache;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory, HasSearch, HasCache;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'secondary_phone',
        'email',

        'city',
        'zipcode',
        'address',

        'company',
    ];

    protected $searchable = [
        'name',
        'phone',
        'secondary_phone',
        'email',

        'city',
        'zipcode',
        'address',
    ];

    protected static function booted()
    {
        self::saving(function ($Self) {
            if (is_null($Self->company)) {
                $Self->company = Core::company('id');
            }
        });

        self::saved(function ($Self) {
            Agency::delCache(
                tags: ['many'],
                keys: ['company_' . Core::company('id') . '_agencies_solo_' . $Self->id],
            );
        });

        self::deleted(function ($Self) {
            Agency::delCache(
                tags: ['many'],
                keys: ['company_' . Core::company('id') . '_agencies_solo_' . $Self->id],
            );
        });
    }

    public function Owner()
    {
        return $this->belongsTo(Company::class, 'company');
    }

    public function Reservations()
    {
        return $this->hasMany(Reservation::class, 'agency');
    }
}
