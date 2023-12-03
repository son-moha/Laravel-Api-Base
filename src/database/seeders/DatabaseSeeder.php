<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth\Database\Seed\PermissionSeeder;
use Modules\Organization\Database\Seed\CompanyRoleSeeder;
use Modules\Organization\Database\Seed\OrgPermissionSeeder;
use Modules\Quiz\Database\Seed\QuizPermissionSeeder;
use Modules\Quiz\Database\Seed\QuizSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            \Modules\Auth\Database\Seed\DatabaseSeeder::class,
            PermissionSeeder::class,
        ]);
    }
}
