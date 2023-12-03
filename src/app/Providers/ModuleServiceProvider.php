<?php

namespace App\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    protected array $modules = [];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (!config('cache.enabled')) {
            $this->scan();
        }

        foreach ($this->modules as $module) {
            (new ProviderRepository(
                $this->app,
                new Filesystem(),
                base_path("bootstrap/cache/" . $module->alias . "_module.php")
            )
            )->load($module->providers);
        }
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

    public function scan()
    {
        $paths = [
            $this->app->basePath('modules/*')
        ];

        if (config('core.enable_dev_module')) {
            $paths[] = $this->app->basePath('develops/*');
        }

        foreach ($paths as $path) {
            $manifests = $this->app['files']->glob("{$path}/module.json");
            is_array($manifests) || $manifests = [];
            foreach ($manifests as $manifest) {
                $this->modules[] = json_decode(file_get_contents($manifest));
            }
        }
    }
}
