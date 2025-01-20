<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait HasCache
{
    protected static function addCache($key, $tag = '')
    {
        $Cache = json_decode(Cache::get('Cache'), true) ?? [];
        $Cache[self::class] = $Cache[self::class] ?? [];

        if (array_search($key, array_column($Cache[self::class], 0)) === false) {
            $Cache[self::class][] = [$key, $tag];
            Cache::forget('Cache');
            Cache::rememberForever('Cache', fn () => json_encode($Cache));
        }

        return $key;
    }

    public static function delCache($keys = null, $tags = null)
    {
        $Cache = json_decode(Cache::get('Cache'), true) ?? [];

        if (!isset($Cache[self::class])) {
            return;
        }

        if ($keys !== null) {
            foreach ($keys as $key) {
                $Cache[self::class] = array_filter(
                    $Cache[self::class],
                    fn ($item) => $item[0] !== $key
                );
                Cache::forget($key);
            }
        }

        if ($tags !== null) {
            foreach ($tags as $tag) {
                $matchingKeys = array_map(
                    fn ($item) => $item[0],
                    array_filter($Cache[self::class], fn ($item) => $item[1] === $tag)
                );

                $Cache[self::class] = array_filter(
                    $Cache[self::class],
                    fn ($item) => $item[1] !== $tag
                );

                foreach ($matchingKeys as $key) {
                    Cache::forget($key);
                }
            }
        }

        Cache::forget('Cache');
        Cache::rememberForever('Cache', fn () => json_encode($Cache));
    }
}
