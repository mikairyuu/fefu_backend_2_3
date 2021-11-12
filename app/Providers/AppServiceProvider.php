<?php

namespace App\Providers;

use App\Models\Setting;
use App\View\Components\Popup;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Setting::class, function () {
            return Setting::firstOrFail();
        });
    }
}
