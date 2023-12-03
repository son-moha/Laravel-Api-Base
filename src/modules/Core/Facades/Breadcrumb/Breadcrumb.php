<?php

namespace Modules\Core\Facades\Breadcrumb;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @method static Handler push($name, $link = null)
 * @method static Handler pushMultiple(array $data)
 * @method static array | \Illuminate\Support\Collection breadcrumbs()
 * @method static bool isEmpty()
 *
 * @see Handler
 *
 */
class Breadcrumb extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'breadcrumb';
    }
}
