<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => "Marc",
                'surname' => "Peral Cajidos",
                'email' => "m.peral@sapalomera.cat",
                'stage' => "DAW",
                'course' => "2",
                'group' => "A",
                'role' => "Profesor",
                'authority' => "Super Administrador",
            ]
        );
        User::create(
            [
                'name' => "Jesus",
                'surname' => "Peral Cajidos",
                'email' => "marcperal23@gmail.com",
                'stage' => "ASIX",
                'course' => "2",
                'group' => "A",
            ]
        );

        User::create(
            [
                'name' => "ADMIN CICLES",
                'email' => "cicles@sapalomera.cat",
                'role' => "Profesor",
                'authority' => "Super Administrador",
            ]
        );
        User::create(
            [
                'name' => "Xavier Martí",
                'email' => "xmarti@sapalomera.cat",
                'role' => "Profesor",
            ]
        );


        $stage = ["ESO", "BATX", "FPB", "ASIX", "DAW", "SMX"];
        $course = [4, 2, 2, 2, 2, 2];
        $group = [
            ["A", "B", "C"],
            ["A", "B", "C"],
            ["A", "B", "C"],
            ["A"],
            ["A"],
            ["A", "B", "C"],
        ];
        // Generamos los usuarios restantes
        for ($i = 1; $i <= 110; $i++) {
            $randomCourse = rand(0, 5);
            // $randomGroup = $group[$randomCourse];
            $groupList = User::getGroupList();
            $randomGroup = $groupList[rand(0, count($groupList) - 1)];
            User::create([
                'name' => "User",
                'surname' => "$i",
                'email' => "user$i@sapalomera.cat",
                'stage' => $stage[$randomCourse],
                'course' => rand(1, $course[$randomCourse]),
                'group' => $randomGroup,
                'role' => "Alumne",
                'authority' => "Usuari",
            ]);
        }
    }
}
