<?php

use Database\Seeders\AdminSettingSeeder;

use Database\Seeders\UserSeeder;
use Database\Seeders\WorkshopChoiceSeeder;
use Database\Seeders\WorkshopHistorySeeder;
use Database\Seeders\WorkshopSeeder;
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
        $this->call(WorkshopSeeder::class);
        $this->call(WorkshopChoiceSeeder::class);
        $this->call(AdminSettingSeeder::class);
        $this->call(WorkshopHistorySeeder::class);
    }
}
