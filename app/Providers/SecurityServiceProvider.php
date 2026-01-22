<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class SecurityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register custom Blade directive for safe output
        Blade::directive('safe', function ($expression) {
            return "<?php echo htmlspecialchars($expression, ENT_QUOTES, 'UTF-8'); ?>";
        });
        
        // Add security headers via response macro
        if (!app()->runningInConsole()) {
            app()->afterResolving('Illuminate\Contracts\Http\Kernel', function ($kernel) {
                $kernel->pushMiddleware(\App\Http\Middleware\SecurityHeadersMiddleware::class);
            });
        }
    }
}
