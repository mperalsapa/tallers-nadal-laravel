<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            ]
        );
        User::create(
            [
                'name' => "Xavier Martí",
                'email' => "xmarti@sapalomera.cat",
            ]
        );

        // Generamos los usuarios restantes
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "User",
                'surname' => "$i",
                'email' => "user$i@sapalomera.cat",
                'stage' => "DAW",
                'course' => "2",
                'group' => "A",
                'role' => "Alumne",
                'authority' => "Usuari",
            ]);
        }
    }
}
