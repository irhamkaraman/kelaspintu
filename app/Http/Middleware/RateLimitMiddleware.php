<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RateLimitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $action, int $maxAttempts = 3, int $decayHours = 48): Response
    {
        $user = $request->user();
        $ipAddress = $request->ip();
        
        // For tracking: use user_id if logged in, otherwise use IP address
        $userId = $user ? $user->id : null;
        
        // Calculate time threshold
        $threshold = now()->subHours($decayHours);
        
        // Count recent actions
        // For logged-in users: track by user_id
        // For guests: track by IP address
        $query = DB::table('rate_limits')
            ->where('action_type', $action)
            ->where('created_at', '>=', $threshold);
        
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('ip_address', $ipAddress)
                  ->whereNull('user_id');
        }
        
        $recentActions = $query->count();

        // Check if limit exceeded
        if ($recentActions >= $maxAttempts) {
            // Log suspicious activity
            Log::warning('Rate limit exceeded', [
                'user_id' => $userId,
                'email' => $user ? $user->email : 'guest',
                'action' => $action,
                'attempts' => $recentActions,
                'ip' => $ipAddress,
                'user_agent' => $request->userAgent(),
            ]);

            return response()->json([
                'message' => "Anda telah mencapai batas maksimum. Maksimal {$maxAttempts}x dalam {$decayHours} jam terakhir. Silakan coba lagi nanti.",
                'retry_after' => $threshold->addHours($decayHours)->diffForHumans(),
                'max_attempts' => $maxAttempts,
                'decay_hours' => $decayHours,
            ], 429);
        }

        // Process request
        $response = $next($request);

        // Record this action if request was successful (2xx or 3xx status)
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 400) {
            DB::table('rate_limits')->insert([
                'user_id' => $userId,
                'action_type' => $action,
                'ip_address' => $ipAddress,
                'metadata' => json_encode([
                    'user_agent' => $request->userAgent(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                ]),
                'created_at' => now(),
            ]);
        }

        return $response;
    }
}
