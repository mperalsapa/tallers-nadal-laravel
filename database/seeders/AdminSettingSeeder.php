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
            "name" => "Inici de seleccio",
            "value" => "2023-02-24T06:23",
        ]);
    }
}
