<?php

namespace App\Models;

use App\Functions\Core;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'email',
        'phone',
        'address',
        'password',

        'company'
    ];

    protected $searchable = [
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'email',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    protected static function booted()
    {
        self::saving(function ($Self) {
            if (is_null($Self->company)) {
                $Self->company = Core::company('id');
            }
        });

        // self::saved(function ($Self) {
        //     Core::delCache(User::class);
        //     Core::delCache(User::class, 'company/' . Core::company('id') . '/users/' . $Self->id);
        // });

        self::created(function ($Self) {
            $Self->Preference()->create([
                'language' => 'fr',
                'currency' => 'MAD',
                'report_frequency' => 'week',
                'date_format' => 'YYYY-MM-DD',
                'theme_color' => 'ocean tide',
            ]);
        });

        self::deleted(function ($Self) {
            $Self->Preference()->delete();
            // Core::delCache(User::class);
            // Core::delCache(User::class, 'company/' . Core::company('id') . '/users/' . $Self->id);
        });
    }

    public function Owner()
    {
        return $this->belongsTo(Company::class, 'company');
    }

    public function Preference(): MorphOne
    {
        return $this->morphOne(Preference::class, 'target');
    }

    public function Comment(): MorphOne
    {
        return $this->morphOne(Comment::class, 'target');
    }
}
