<?php

namespace Modules\Auth\Database\Seed;

use Modules\Auth\Constants\AuthConst;
use Modules\Auth\Entities\Models\Permission;
use Modules\Auth\Entities\Models\User;
use Modules\Auth\Entities\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::factory()->create(['name' => 'SuperAdmin', 'email' => 'super@mail.io']);
        $superAdmin->detail()->create();

        $superAdminRole = Role::factory()->create([
            'name' => 'role.super-admin',
            'display_name' => 'auth::role.name.IT Admin',
            'description' => 'Role super admin, allowed every action'
        ]);
        $superAdmin->assignRole($superAdminRole);
    }
}
