<?php

use Modules\Auth\Entities\Models\User;

if (!function_exists('fn_get_main_id')) {
    function fn_get_main_id()
    {
        return \Illuminate\Support\Facades\Session::get('adminId', false);
    }
}

if (!function_exists('fn_has_login_as')) {
    function fn_has_login_as()
    {
        return fn_get_main_id() && (fn_get_main_id() !== (fn_auth() ? fn_auth()->id : null));
    }
}

if (!function_exists('fn_auth()')) {
    /**
     * @return User | null
     */
    function fn_auth()
    {
        /* @var $user User */
        $user = auth()->user();

        return $user;
    }
}
