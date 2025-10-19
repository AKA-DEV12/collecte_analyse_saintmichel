<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production to avoid mixed content and cookie issues behind a proxy (Render)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');

            // Trust proxy headers (X-Forwarded-*) so Laravel detects HTTPS correctly behind Render
            try {
                Request::setTrustedProxies(['*'],
                    Request::HEADER_X_FORWARDED_FOR
                    | Request::HEADER_X_FORWARDED_HOST
                    | Request::HEADER_X_FORWARDED_PROTO
                    | Request::HEADER_X_FORWARDED_PORT
                    | Request::HEADER_X_FORWARDED_AWS_ELB
                );
            } catch (\Throwable $e) {
                // ignore if not supported in runtime
            }
        }
    }
}
