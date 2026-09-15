<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    /**
     * Get cached data or store new
     */
    public static function remember($key, $minutes, $callback)
    {
        return Cache::remember($key, $minutes * 60, $callback);
    }

    /**
     * Forget cache by key
     */
    public static function forget($key)
    {
        Cache::forget($key);
    }

    /**
     * Forget multiple cache keys
     */
    public static function forgetMany($keys)
    {
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Get cache key for model
     */
    public static function modelKey($model, $suffix = '')
    {
        $modelName = class_basename($model);
        $id = $model->id ?? 'all';
        return $modelName . '_' . $id . ($suffix ? '_' . $suffix : '');
    }
}