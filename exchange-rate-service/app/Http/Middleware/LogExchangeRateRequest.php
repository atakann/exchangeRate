<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogExchangeRateRequest
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check()) { // Check if user is authenticated
            $userId = auth()->user()->id; // Get the user ID
            Log::info("User {$userId} requested exchange rates.");
        }

        return $response;
    }
}