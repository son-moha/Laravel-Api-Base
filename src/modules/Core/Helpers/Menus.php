<?php

namespace Modules\Core\Helpers;

class Menus
{
    protected $menus = [];

    public function pushMenu($menu)
    {
        $group = (int) $menu['group'] ?? null;
        $groupName = $menu['group_name'] ?? '';

        if ($groupName) {
            $this->menus[$group]['name'] = $groupName;
            $this->menus[$group]['child'][$menu['pos_child']] = $menu;
        } else {
            $this->menus[$group]['single'] = $menu;
        }
    }

    public function renders()
    {
        ksort($this->menus);

        $view = view('core::_partials.sidebar_extends', [
            'menus' => $this->menus,
        ]);

        echo $view->render();
    }
}
