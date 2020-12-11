<?php

namespace Modules\AdminUser\Database\Seeders;

use Modules\AdminUser\Entities\AdminUser;
use Illuminate\Database\Seeder;

class AdminUserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Model::unguard();

        AdminUser::factory()->times(100)->create();

        //Model::guard();

        // $this->call("OthersTableSeeder");
    }
}
