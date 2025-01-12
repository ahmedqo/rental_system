<?php

namespace App\Models;

use App\Functions\Core;
use Carbon\Carbon;
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

    public function Parse($setting)
    {
        $vars = json_decode($this->vars, true);
        if (isset($vars['date'])) $vars['date'] = Carbon::parse($vars['date'])->translatedFormat($setting ? Core::formatsList($setting->date_format, 1) : 'Y-m-d');
        if (isset($vars['money'])) $vars['money'] = $vars['money'] . ' ' . ($setting ? $setting->currency : 'MAD');

        return __($this->text, $vars);
    }

    public function Target(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'target_type', 'target_id');
    }
}
