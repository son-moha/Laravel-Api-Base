<?php

namespace Modules\Core\Providers;

use Modules\Core\Helpers\HtmlMacros;
use Spatie\Html\HtmlServiceProvider;

class MacroServiceProvider extends HtmlServiceProvider
{
    protected function registerHtmlBuilder()
    {
        $this->app->singleton('html', function ($app) {
            return new HtmlMacros($app['url'], $app['view']);
        });
    }
}
