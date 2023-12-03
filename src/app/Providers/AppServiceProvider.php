<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Facades\Breadcrumb\Handler;
use Modules\Core\Helpers\Menus;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('menu', function () {
            return new Menus();
        });

        $this->app->singleton('breadcrumb', function () {
            return new Handler();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
