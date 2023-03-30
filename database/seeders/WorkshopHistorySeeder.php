<?php

namespace Database\Seeders;


use App\Models\WorkshopHistory;
use Illuminate\Database\Seeder;

class WorkshopHistorySeeder extends Seeder
{
    public function run()
    {
        WorkshopHistory::create([
            'name' => 'Taller de cocina',
            'creator' => "Marc Peral Cajidos",
            'description' => 'Aprende a cocinar deliciosos platillos',
            'addressed_to' => ["1ASIX", "2ASIX"],
            'max_students' => 10,
            'material' => 'Cuchillos, tabla de cortar, ingredientes',
            'observations' => 'Se requiere traer un delantal',
            'created' => "2022",
        ]);
    }
}
