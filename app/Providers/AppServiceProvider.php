<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        RateLimiter::for('login', function (Request $request) {
            $input = $request->input('email');
            $email = is_string($input)
                ? Str::transliterate(Str::lower(trim($input)))
                : '';

            return [
                Limit::perMinute(5)->by('login:'.hash('sha256', $email).'|'.$request->ip()),
                Limit::perMinute(30)->by('login-ip:'.$request->ip()),
            ];
        });

        RateLimiter::for('password-reset', function (Request $request) {
            return Limit::perMinute(3)->by('password-reset:'.$request->ip());
        });

        RateLimiter::for('verification-notification', function (Request $request) {
            return [
                Limit::perMinute(6)->by('verification-user:'.$request->user()->getAuthIdentifier()),
                Limit::perMinute(30)->by('verification-ip:'.$request->ip()),
            ];
        });
    }
}
