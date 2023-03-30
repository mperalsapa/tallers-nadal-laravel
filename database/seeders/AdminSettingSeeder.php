<?php

namespace Database\Seeders;

use App\Models\AdminSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSettingSeeder extends Seeder
{
    public function run()
    {
        AdminSetting::create([
            "name" => "startingDate",
            "fancyName" => "Inici de seleccio",
            "value" => "2023-04-01T06:23",
        ]);
        AdminSetting::create([
            "name" => "endingDate",
            "fancyName" => "Fi de seleccio",
            "value" => "2023-04-10T06:23",
        ]);
        AdminSetting::create([
            "name" => "checkedUserAsignedWorkshops",
            "fancyName" => "Usuaris amb taller assignat",
            "value" => 0,
        ]);
        AdminSetting::create([
            "name" => "checkedUserChoseWorkshops",
            "fancyName" => "Usuaris amb eleccions de taller",
            "value" => 0,
        ]);
    }
}
