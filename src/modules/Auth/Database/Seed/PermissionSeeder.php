<?php

namespace Modules\Auth\Database\Seed;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Constants\AuthConst;
use Modules\Auth\Constants\PermissionConst;
use Modules\Auth\Entities\Models\Permission;
use Modules\Auth\Entities\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dt_permission_role')->truncate();
        DB::table('ms_permissions')->delete();

        /* @var $superAdmin Role */
        $superAdmin = Role::whereName(AuthConst::ROLE_SUPER_ADMIN)->first();
        /* @var $municipalAdminRole Role */

        $this->assignUserPermission($superAdmin);
    }

    protected function assignUserPermission(Role $superAdmin)
    {
        $p_user_create  = Permission::factory()->create([
            'name'        => 'user' . PermissionConst::PERMISSION_CREATE,
            'description' => 'Create entities, show button create'
        ]);
        $p_user_read    = Permission::factory()->create([
            'name'        => 'user' . PermissionConst::PERMISSION_READ,
            'description' => 'View list entities,show link in menu']);
        $p_user_update  = Permission::factory()->create([
            'name'        => 'user' . PermissionConst::PERMISSION_UPDATE,
            'description' => 'Update entities, show button edit']);
        $p_user_delete  = Permission::factory()->create([
            'name'        => 'user' . PermissionConst::PERMISSION_DELETE,
            'description' => 'Delete entities, show button delete']);
        $p_user_loginAs = Permission::factory()->create([
            'name'        => 'user.loginAs',
            'description' => 'Login as user']);

        $superAdmin->allowTo($p_user_create);
        $superAdmin->allowTo($p_user_read);
        $superAdmin->allowTo($p_user_update);
        $superAdmin->allowTo($p_user_delete);
        $superAdmin->allowTo($p_user_loginAs);
    }
}
