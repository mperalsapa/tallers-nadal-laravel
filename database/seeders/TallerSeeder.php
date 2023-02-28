<?php

namespace Database\Seeders;

use App\Models\Taller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TallerSeeder extends Seeder
{
    public function run()
    {
        Taller::create([
            'name' => 'Taller de cocina',
            'user_id' => 1,
            'description' => 'Aprende a cocinar deliciosos platillos',
            'addressed_to' => ["1ASIX", "2ASIX"],
            'max_students' => 10,
            'material' => 'Cuchillos, tabla de cortar, ingredientes',
            'observations' => 'Se requiere traer un delantal',
            'created' => now(),
        ]);
        Taller::create(
            [
                'name' => 'Taller de dibujo',
                'user_id' => 2,
                'description' => 'Aprende a dibujar retratos realistas',
                'addressed_to' => ["1SMX", "2SMX"],
                'max_students' => 8,
                'material' => 'Papel, lápices, goma de borrar',
                'observations' => 'No se permiten teléfonos móviles en clase',
                'created' => now(),
                'updated_at' => now(),
            ]
        );
        for ($i = 5; $i <= 14; $i++) {
            $name = "Taller $i";
            $user_id = $i; // Id de usuario aleatorio
            $description = "Descripción del taller $i";
            $addressed_to = ["1SMX", "2SMX"]; // Dirigido a los cursos 1SMX y 2SM]X
            $max_students = rand(5, 10); // Máximo de estudiantes entre 5 y 10
            $material = "Material necesario para el taller $i";
            $observations = "Observaciones para el taller $i";

            Taller::create([
                'name' => $name,
                'user_id' => $user_id,
                'description' => $description,
                'addressed_to' => $addressed_to,
                'max_students' => $max_students,
                'material' => $material,
                'observations' => $observations,
                'created' => now()
            ]);
        }
    }
}
