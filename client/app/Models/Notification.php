<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'target_id',
        'target_type',
        'text',
        'vars',
        'view',
    ];

    public function getContentAttribute()
    {
        $vars = json_decode($this->vars, true);
        return __($this->text, $vars);
    }

    public function Target(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'target_type', 'target_id');
    }
}
