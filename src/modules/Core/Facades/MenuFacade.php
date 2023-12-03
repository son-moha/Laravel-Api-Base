<?php

namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class MenuFacade
 * @package \Modules\Core\Facades
 *
 * @method static \Modules\Core\Helpers\Menus pushMenu($menu)
 * @method static \Modules\Core\Helpers\Menus renders()
 *
 * @see Menus
 */
class MenuFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'menu';
    }
}
