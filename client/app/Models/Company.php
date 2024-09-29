<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',

        'ice_number',
        'license_number',

        'city',
        'zipcode',
        'address',

        'mileage_per_day',
    ];

    protected static function booted()
    {
        self::created(function ($Self) {
            Image::$FILE = request('company_logo');
            $Self->Image()->create();
        });

        self::deleted(function ($Self) {
            Storage::disk('public')->delete(implode('/', [Image::$STORAGE, $Self->Image->storage]));
            $Self->Image->delete();
        });
    }

    public function Image(): MorphOne
    {
        return $this->morphOne(Image::class, 'target');
    }

    public function Agencies()
    {
        return $this->hasMany(Agency::class, 'company');
    }

    public function Charges()
    {
        return $this->hasMany(Charge::class, 'company');
    }

    public function Clients()
    {
        return $this->hasMany(Client::class, 'company');
    }

    public function Payments()
    {
        return $this->hasMany(Payment::class, 'company');
    }

    public function Recoveries()
    {
        return $this->hasMany(Recovery::class, 'company');
    }

    public function Reminders()
    {
        return $this->hasMany(Reminder::class, 'company');
    }

    public function Reservations()
    {
        return $this->hasMany(Reservation::class, 'company');
    }

    public function Restrictions()
    {
        return $this->hasMany(Restriction::class, 'company');
    }

    public function Tickets()
    {
        return $this->hasMany(Ticket::class, 'company');
    }

    public function Users()
    {
        return $this->hasMany(User::class, 'company');
    }

    public function Vehicles()
    {
        return $this->hasMany(Vehicle::class, 'company');
    }

    public function Representative()
    {
        return $this->hasOne(User::class, 'company');
    }
}
