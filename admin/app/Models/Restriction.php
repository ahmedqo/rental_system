<?php

namespace App\Models;

use App\Functions\Core;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restriction extends Model
{
    use HasFactory, HasSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client',
        'reasons',

        'company',
    ];

    protected $searchable = [
        'client.identity_type',
        'client.identity_number',
        'client.identity_issued_in',
        'client.identity_issued_at',

        'client.license_number',
        'client.license_issued_in',
        'client.license_issued_at',

        'client.first_name',
        'client.last_name',
        'client.email',
        'client.phone',
        'client.nationality',

        'client.gender',
        'client.birth_date',
        'client.city',
        'client.zipcode',
        'client.address',

        'reasons',
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
}
