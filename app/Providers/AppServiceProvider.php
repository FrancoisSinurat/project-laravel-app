<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app['files']->requireOnce(__DIR__.'/../Helpers/Helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!$this->app->environment('local')) {
            URL::forceScheme('https');
            $url = $this->app['url'];
            // Force the application URL
            $url->forceRootUrl(config('app.url'));
        }
    }
}
