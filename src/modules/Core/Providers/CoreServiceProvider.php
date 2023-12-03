<?php

namespace Modules\Core\Providers;

use Modules\Core\Console\Commands\LanguageJS;
use Modules\Core\Console\Commands\TestMail;
use Modules\Core\Console\Commands\TestStorage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once(__DIR__ . '/../Helpers/functions.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'core');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'core');
        $this->mergeConfigFrom(__DIR__ . '/../Config/core.php', 'core');

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(MacroServiceProvider::class);
        $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('HTTPS') == 'on') {
            URL::forceScheme('https');
        }
    }

    public function registerCommands()
    {
        $this->commands([
            TestMail::class,
            LanguageJS::class,
            TestStorage::class,
        ]);
    }
}
