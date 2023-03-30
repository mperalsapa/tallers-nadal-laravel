<?php

namespace App\Http\Controllers;

use App\Models\Taller;
use App\Models\TallerChoice;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Dd;

class index extends Controller
{
    public function index()
    {

        $users = User::all();
        foreach ($users as $user) {
            if ($user->assignedWorkshop == null) {
                echo "No assigned workshop: " . $user->email . "<br>";
                continue;
            }
            echo "Assigned workshop: " . $user->email . "<br>";
        }
    }
    public function oldIndex()
    {



        // $file = fopen(storage_path("usuaris.txt"), "r");
        // if (file_exists(storage_path("usuaris.csv"))) {
        //     $file = fopen(storage_path("usuaris.csv"), "r");
        // } else {
        //     $file = fopen(storage_path("usuaris.txt"), "r");
        // }





        $file = fopen(storage_path("usuaris.csv"), "r");

        $users = array();
        while (!feof($file)) {


            $line = fgets($file);
            $userData = str_getcsv($line);
            if (count($userData) == 0) {
                continue;
            }

            $user = new User;

            $user->email = $userData[0];
            $user->stage = $userData[1];
            $user->course = $userData[2];
            $user->group = $userData[3];
            $user->surname = $userData[4];
            $user->name = $userData[5];

            // checking if email contains dot so it's a student or teacher
            // user email: u.user@domain.com
            // teacher email: uuser@domain.com

            if (!preg_match("/\..*@/", $user->email)) {
                $user->role = "Profesor";
            }



            try {
                $user->save();
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                if ($errorCode == 1062) {
                    echo "S'ha trobat un usuari duplicat: " . $user->email . "<br>";
                } else {
                    dd($e);
                }
            }

            // append user to users array
            array_push($users, $user);














            // grab email, stage, class, group, surname1, surname2 and name from "a.alumne1@sapalomera.cat OU=ESO1A Cognom1 Cognom1, Nom1"
            // $line = fgets($file);
            // // match line with regex to get email, stage, class, group, surname1, surname2 and name
            // preg_match("/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9_-]+)\s+OU=([aA-zZ]{3,4})(\d)([A-Z])\s*(.*),\s*(.*)\s*$/", $line, $user);
            // if (count($user) == 0) {
            //     continue;
            // }

            // try {
            //     $users = User::create([
            //         'email' => $user[1],
            //         'stage' => $user[2],
            //         'class' => $user[3],
            //         'group' => $user[4],
            //         'surname' => $user[5],
            //         'name' => $user[6],
            //     ]);
            // } catch (\Illuminate\Database\QueryException $e) {
            //     dd($e);
            // }
            // dd($user);
            // print("<pre>" . print_r($user, true) . "</pre>");



            // echo fgets($file) . "<br>";
        }

        fclose($file);




        return "hola";

        // \Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
        //     // echo "<br><br>";
        //     var_dump($query->sql);
        //     echo "<br><br>";
        //     // var_dump($query->bindings);
        //     // echo "<br><br>";
        //     // var_dump($query->time);
        // });
        // manual user seek
        // $userId = session()->get('id');
        // $user = User::find($userId);
        // $user->touch();

        // dd(Auth::user());
        // echo "hola " . Auth::user()->name;
        // echo "Hola " . $user->name . ". Tens rol de: " . $user->role->name;
        // $users = User::with(['tallerChoices.firstChoice', 'tallerChoices.secondChoice', 'tallerChoices.thirdChoice'])->get();

        // $user = User::find(1)->tallerChoices->firstChoice;
        // dd($user);

        // foreach ($users as $user) {
        //     // dd($user->tallerChoices);
        //     echo "Nombre de usuario: " . $user->name . " " . $user->surname . "<br>";
        //     // dd($user->tallerChoices->firstChoice);
        //     if (is_null($user->tallerChoices)) {
        //         continue;
        //     }
        //     if (!is_null($user->tallerChoices->firstChoice)) {
        //         echo "Elección 1: " . $user->tallerChoices->firstChoice->name . "<br>";
        //     }
        //     if (!is_null($user->tallerChoices->secondChoice)) {
        //         echo "Elección 2: " . $user->tallerChoices->secondChoice->name . "<br>";
        //     }
        //     if (!is_null($user->tallerChoices->thirdChoice)) {
        //         echo "Elección 2: " . $user->tallerChoices->thirdChoice->name . "<br>";
        //     }
        //     // foreach ($user->tallerChoices as $tallerChoice) {
        //     //     // $taller2 = is_null($tallerChoice->secondTaller) ? "Null" : "Not null";
        //     //     // echo "Eleccio 1:" .  is_null($tallerChoice->firstTaller->name) ? "No ha seleccionat" : $tallerChoice->firstTaller->name;
        //     //     // echo "Eleccio 2:" .  is_null($tallerChoice->secondTaller->name) ? "No ha seleccionat" : $tallerChoice->secondTaller->name;
        //     //     // echo "Elección 2: " . $tallerChoice->secondTaller->name . "\n";
        //     // }
        //     echo "<br>";

        // }

        // dd(Taller::find($tallerChoices->first_choice));
        // dd($tallerChoices);

        // dd();
        // return;
        // return view("user.index", array());
    }

    public function index1()
    {
        return "hola user";
    }
    public function index2()
    {
        // return 
        return "hola admin :D";
    }
}
