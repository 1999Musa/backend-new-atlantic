<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use App\Models\ShortStoryVideo;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after login.
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
          parent::boot();

    Route::model('short_story', ShortStoryVideo::class);

        $this->routes(function () {
            // Load api.php routes
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Load web.php routes
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
