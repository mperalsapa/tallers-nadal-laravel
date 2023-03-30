<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Workshop;
use Illuminate\Database\Seeder;

class WorkshopSeeder extends Seeder
{
    public function run()
    {
        Workshop::create([
            'name' => 'Taller de cocina',
            'user_id' => 1,
            'description' => 'Aprende a cocinar deliciosos platillos',
            'addressed_to' => ["1ASIX", "2ASIX", "2DAW"],
            'max_students' => 10,
            'material' => 'Cuchillos, tabla de cortar, ingredientes',
            'observations' => 'Se requiere traer un delantal',
            'created' => date("Y"),
        ]);
        Workshop::create(
            [
                'name' => 'Taller de dibujo',
                'user_id' => 2,
                'description' => 'Aprende a dibujar retratos realistas',
                'addressed_to' => ["2ASIX", "2DAW"],
                'max_students' => 8,
                'material' => 'Papel, lápices, goma de borrar',
                'observations' => 'No se permiten teléfonos móviles en clase',
                'created' => date("Y"),
                'updated_at' => now(),
            ]
        );
        $courseList = User::getCourseList();
        for ($i = 5; $i <= 100; $i++) {
            $randomCourses = array();

            // loop through the courses and add a maximum quantity randomly
            $randomCourses = array_rand($courseList, rand(1, 3));
            if (!is_array($randomCourses)) {
                $randomCourses = array($randomCourses);
            }

            $name = "Taller $i";
            $user_id = $i; // Id de usuario aleatorio
            $description = "Descripción del taller $i";
            $addressed_to = $randomCourses; // Dirigido a los cursos 1SMX y 2SM]X
            $max_students = rand(5, 10); // Máximo de estudiantes entre 5 y 10
            $material = "Material necesario para el taller $i";
            $observations = "Observaciones para el taller $i";

            Workshop::create([
                'name' => $name,
                'user_id' => $user_id,
                'description' => $description,
                'addressed_to' => $addressed_to,
                'max_students' => $max_students,
                'material' => $material,
                'observations' => $observations,
                'created' => date("Y"),
            ]);
        }
    }
}
