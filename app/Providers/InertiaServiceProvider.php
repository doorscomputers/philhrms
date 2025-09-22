<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class InertiaServiceProvider extends ServiceProvider
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
        Inertia::setRootView('app');

        Inertia::share([
            'auth' => fn () => [
                'user' => auth()->user(),
            ],
            'flash' => fn () => [
                'message' => session('message'),
                'success' => session('success'),
                'error' => session('error'),
            ],
        ]);
    }
}
