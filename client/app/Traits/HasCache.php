<?php

namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Cache;

trait HasCache
{
    public static function addKeys($key)
    {
        if (!in_array($key, self::$cachableList)) self::$cachableList[] = $key;
        return $key;
    }

    public static function addKey($key)
    {
        if (!in_array($key, self::$cachableSingle)) self::$cachableSingle[] = $key;
        return $key;
    }

    public static function delKeys()
    {
        foreach (self::$cachableList as $key) {
            Cache::forget($key);
        }

        self::$cachableList = [];
    }

    public static function delKey($key)
    {
        static::$cachableSingle = array_reduce(static::$cachableSingle, function ($carry, $item) use ($key) {
            if ($item !== $key) $carry[] = $item;
            return $carry;
        }, []);
    }
}
