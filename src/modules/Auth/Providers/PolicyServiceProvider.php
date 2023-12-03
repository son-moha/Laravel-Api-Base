<?php

namespace Modules\Auth\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Modules\Auth\Constants\AuthConst;
use Modules\Auth\Entities\Models\User;
use Modules\Auth\Policies\UserPolicy;

class PolicyServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function (User $user) {
            if ($user->roles->pluck('name')->contains(AuthConst::ROLE_SUPER_ADMIN)) {
                //admin always pass;
                return true;
            }
        });
    }
}
