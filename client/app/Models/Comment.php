<?php

namespace App\Models;

use App\Traits\HasCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory, HasCache;

    protected $fillable = [
        'ticket',
        'target_id',
        'target_type',
        'content'
    ];

    public function Ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket');
    }

    public function Target(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'target_type', 'target_id');
    }
}
