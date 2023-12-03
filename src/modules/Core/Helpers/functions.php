<?php

function is_json($string)
{
    json_decode($string);

    return (json_last_error() == JSON_ERROR_NONE);
}

if (!function_exists('activity')) {
    /**
     * @return \Modules\Core\Services\Activity\ActivityService
     */
    function activity()
    {
        return app(\Modules\Core\Services\Activity\ActivityService::class);
    }
}

if (!function_exists('storage_url')) {
    function storage_url($path)
    {
        if ($path) {
            return \Illuminate\Support\Facades\Storage::url($path);
        }

        return '';
    }
}

if (!function_exists('public_url')) {
    function public_url($path)
    {
        if ($path) {
            return asset($path);
        }

        return '';
    }
}

if (!function_exists('back_link')) {
    function back_link()
    {
        return url()->previous();
    }
}

if (!function_exists('route_wildcard')) {
    function route_wildcard($routeName, $level = 2)
    {
        $routeLevel = explode('.', $routeName);
        $wildcard   = '';

        for ($i = 0; $i < $level; $i++) {
            if (isset($routeLevel[$i])) {
                $wildcard .= $routeLevel[$i];
                if ($i !== ($level - 1)) {
                    $wildcard .= '.';
                }
            }
        }

        return $wildcard . '*';
    }
}

if (!function_exists('route_active')) {
    function route_active_group($routes)
    {
        foreach ($routes as $route) {
            if (route_active(route_wildcard($route))) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('begin_transaction')) {
    function begin_transaction()
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
    }
}

if (!function_exists('commit_transaction')) {
    function commit_transaction()
    {
        \Illuminate\Support\Facades\DB::commit();
    }
}

if (!function_exists('rollback_transaction')) {
    function rollback_transaction()
    {
        \Illuminate\Support\Facades\DB::rollBack();
    }
}

if (!function_exists('route_active')) {
    function route_active($route)
    {
        return request()->routeIs($route);
    }
}

if (!function_exists('get_tenant_id')) {
    function get_tenant_id()
    {
        return null;
    }
}

if (!function_exists('renderHeader')) {
    function renderHeader($columns, $curSort, $url = false, $checkAll = true, $requestField = false): string
    {
        $result = '';
        if ($checkAll) {
            $result .= '<th style="width: 20px;">
<label class="m-checkbox m-checkbox--solid m-checkbox--brand align-top">
                <input type="checkbox" class="chk-all"><span></span></label></th>';
        }

        $url             = (!$url) ? url()->current() : $url;
        $current_request = request()->query();

        if ($requestField !== false) {
            $current_request = request()->only($requestField);
        }

        $current_sort = parseSorting(request('order_by', $curSort));

        renderTr($result, $columns, $url, $current_request, $current_sort);

        return $result;
    }
}

if (!function_exists('parseSorting')) {
    function parseSorting($string): array
    {
        $result = [];

        if ($string == '-intended_date') {
            $result['date_ok'] = 'DESC';
            $result['time_ok'] = 'DESC';
        }
        if ($string == 'intended_date') {
            $result['date_ok'] = 'ASC';
            $result['time_ok'] = 'ASC';
        }

        $sort = explode(',', $string);
        $sort = array_map(function ($s) {
            $s = filter_var($s, FILTER_SANITIZE_STRING);
            return trim($s);
        }, $sort);
        foreach ($sort as $expr) {
            if (empty($expr)) {
                continue;
            }
            if (str_starts_with($expr, '-')) {
                $result[substr($expr, 1)] = 'DESC';
            } else {
                $result[$expr] = 'ASC';
            }
        }

        return $result;
    }
}

if (!function_exists('renderTr')) {
    function renderTr(&$result, $columns, $url, $current_request, $current_sort): void
    {
        foreach ($columns as $k => $v) {
            if (!empty($v['hidden'])) {
                continue;
            }
            $gen_url = ['order_by' => $k];
            if (isset($current_sort[$k])) {
                if ($current_sort[$k] == 'ASC') {
                    $gen_url['order_by'] = '-' . $k;
                }
            }

            $sortUrl      = $url . '?' . http_build_query(array_merge($current_request, $gen_url));
            $column_style = '';
            $column_name  = $v;
            if (is_array($v)) {
                $column_name  = $v['name'] ?? '';
                $column_style .= (isset($v['style'])) ? ' style="' . $v['style'] . '" ' : '';
            }

            $iconSort = '';
            $sortable = !empty($v['sortable']);

            if ($sortable) {
                $col_class = 'class="sorting"';
                if (isset($current_sort[$k])) {
                    $col_class = 'class="sorting table-sort-desc"';
                    if ($current_sort[$k] == 'ASC') {
                        $col_class = 'class="sorting table-sort-asc"';
                    }
                }
                $column_style .= $col_class;

                $result .= '<th ' . $column_style . '><a href="' . $sortUrl . '">' . $column_name . '</a></th>';
            } else {
                $result .= '<th ' . $column_style . '>' . $column_name . $iconSort . '</th>';
            }
        }
    }
}
