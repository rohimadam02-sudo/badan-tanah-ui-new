<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheResponse
{
    public function handle(Request $request, Closure $next, $ttl = 3600)
    {
        if ($request->isMethod('get') && !$request->user()) {
            $key = 'response_' . md5($request->fullUrl());
            
            if (Cache::has($key)) {
                return response(Cache::get($key))->header('X-Cache', 'HIT');
            }
            
            $response = $next($request);
            
            if ($response->isSuccessful()) {
                Cache::put($key, $response->getContent(), $ttl);
            }
            
            return $response->header('X-Cache', 'MISS');
        }
        
        return $next($request);
    }
}