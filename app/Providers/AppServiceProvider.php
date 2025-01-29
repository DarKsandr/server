<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Facades\SshService::class, fn() => app(\App\Services\SshService::class));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Http::macro('keenetic', function () {
            return Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->baseUrl(config('keenetic.base_url') . 'rci/');
        });
    }
}
