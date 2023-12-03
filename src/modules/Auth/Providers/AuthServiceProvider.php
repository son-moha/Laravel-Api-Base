<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Entities\Models\User;
use Modules\Core\Facades\MenuFacade;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'auth');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', 'auth');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        require_once(__DIR__ . '/../Helpers/functions.php');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerCommands();

        MenuFacade::pushMenu([
            'group' => 10,
            'group_name' => '',
            'pos_child' => 0,
            'name' => 'auth::text.account management',
            'class' => User::class,
            'route' => 'cp.users.index',
            'icon' => 'user',
        ]);

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(PolicyServiceProvider::class);
    }

    public function registerCommands()
    {
        $this->commands([
        ]);
    }
}
