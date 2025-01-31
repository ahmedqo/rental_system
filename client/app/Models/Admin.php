<?php

namespace App\Models;

use App\Functions\Core;
use App\Traits\HasCache;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasSearch, HasCache;

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
        self::created(function ($Self) {
            $Self->Preference()->create([
                'language' => 'fr',
                'currency' => 'MAD',
                'report_frequency' => 'week',
                'date_format' => 'YYYY-MM-DD',
                'theme_color' => 'ocean tide',
            ]);
        });

        self::saved(function ($Self) {
            Admin::delCache(
                tags: ['many'],
                keys: ['admins_solo_' . $Self->id],
            );
        });


        self::deleted(function ($Self) {
            $Self->Preference()->delete();
            Admin::delCache(
                tags: ['many'],
                keys: ['admins_solo_' . $Self->id],
            );
        });
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
