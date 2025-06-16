<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\settings;
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
    $setting=settings::chackSetting();
    view()->share([
        'setting'=>$setting,
    ]);

    }
}
