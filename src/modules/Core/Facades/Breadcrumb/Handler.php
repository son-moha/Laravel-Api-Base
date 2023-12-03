<?php

namespace Modules\Core\Facades\Breadcrumb;

class Handler
{
    protected $breadcrumbs = [];

    public function __construct()
    {
        $this->breadcrumbs = collect([]);
    }

    /**
     * Push category
     *
     * @param  string  $name
     * @param  string  $link
     *
     * @return $this
     */
    public function push($name, $link = null)
    {
        $this->breadcrumbs->push(['name' => $name, 'link' => $link]);

        return $this;
    }

    public function pushMultiple(array $data)
    {
        foreach ($data as $crumb) {
            $this->push($crumb['name'], $crumb['link'] ?? null);
        }

        return $this;
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function breadcrumbs()
    {
        return $this->breadcrumbs;
    }

    public function isEmpty()
    {
        return !($this->breadcrumbs->count());
    }
}
