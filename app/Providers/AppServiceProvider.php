<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\PersetujuanBimbingan;
use App\Observers\PersetujuanBimbinganObserver;

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
        PersetujuanBimbingan::observe(PersetujuanBimbinganObserver::class);
    }
}
