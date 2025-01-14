<?php

namespace App\Models;

use App\Functions\Core;
use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Ticket extends Model
{
    use HasFactory, HasSearch;

    protected $fillable = [
        'reference',
        'subject',
        'category',
        'status',
        'awaiting_response_from',

        'company'
    ];

    protected $searchable = [
        'reference',
        'subject',
        'category',
        'status',
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

    public function Comments()
    {
        return $this->hasMany(Comment::class, 'ticket');
    }
}
