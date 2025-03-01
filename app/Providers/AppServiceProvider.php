<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\PersetujuanBimbingan;
use App\Models\PersetujuanTA;
use App\Models\TugasAkhir;
use App\Observers\PersetujuanBimbinganObserver;
use App\Observers\PersetujuanTugasAkhirObserver;
use App\Observers\TugasAkhirObserver;
use Carbon\Carbon;

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
        Carbon::setLocale('id');
        PersetujuanBimbingan::observe(PersetujuanBimbinganObserver::class);
        PersetujuanTA::observe(PersetujuanTugasAkhirObserver::class);
        TugasAkhir::observe(TugasAkhirObserver::class);
    }
}
