<?php

use Database\Seeders\AdminSettingSeeder;
use Database\Seeders\CourseSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TallerSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TallerSeeder::class);
        $this->call(AdminSettingSeeder::class);
    }
}
