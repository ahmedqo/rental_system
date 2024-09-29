<?php

namespace App\Models;

use App\Functions\Core;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, HasSearch;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identity_type',
        'identity_number',
        'identity_issued_in',
        'identity_issued_at',

        'license_number',
        'license_issued_in',
        'license_issued_at',

        'first_name',
        'last_name',
        'email',
        'phone',
        'nationality',

        'gender',
        'birth_date',
        'city',
        'zipcode',
        'address',

        'company'
    ];

    protected $searchable = [
        'identity_type',
        'identity_number',
        'identity_issued_in',
        'identity_issued_at',

        'license_number',
        'license_issued_in',
        'license_issued_at',

        'first_name',
        'last_name',
        'email',
        'phone',
        'nationality',

        'gender',
        'birth_date',
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
    }

    public function Owner()
    {
        return $this->belongsTo(Company::class, 'company');
    }

    public function Reservations()
    {
        return $this->hasMany(Reservation::class, 'client');
    }

    public function Restriction()
    {
        return $this->hasOne(Restriction::class, 'client');
    }
}
