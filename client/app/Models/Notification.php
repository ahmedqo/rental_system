<?php

namespace App\Models;

use App\Functions\Core;
use App\Traits\HasCache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    use HasFactory, HasCache;

    protected $fillable = [
        'company',
        'target_id',
        'target_type',
        'text',
        'vars',
        'view',
    ];

    public function Parse($preference)
    {
        $vars = json_decode($this->vars, true);
        if (array_key_exists('vehicle', $vars)) {
            array_walk($vars['vehicle'], function (&$carry, $index) {
                if ($index < 3) $carry = ucfirst(__($carry));
            });
            $vars['vehicle'] = implode(" ", $vars['vehicle']);
        }
        if (array_key_exists('date', $vars))
            $vars['date'] = Carbon::parse($vars['date'])->translatedFormat($preference ? Core::formatsList($preference->date_format, 1) : 'Y-m-d');
        if (array_key_exists('money', $vars))
            $vars['money'] = $vars['money'] . ' ' . ($preference ? $preference->currency : 'MAD');
        if (array_key_exists('consumable', $vars))
            $vars['consumable'] = ucfirst(__($vars['consumable']));

        return __($this->text, $vars);
    }

    public function Target(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'target_type', 'target_id');
    }
}
