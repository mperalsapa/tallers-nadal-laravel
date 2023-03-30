<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopChoice;
use Illuminate\Http\Request;

class adminUser extends Controller
{
    public function showUsers(Request $request)
    {
        $params = $request->all();
        if ($params) {
            $users = User::with(['workshopChoices.firstChoice', 'workshopChoices.secondChoice', 'workshopChoices.thirdChoice']);
            // $users = User::query();
            foreach ($params as $field => $value) {
                if (method_exists(User::class, "scope{$field}") && $value != "") {
                    $users = $users->$field($value);
                }
            }
            $users = $users->paginate(30);
        } else {

            $users = User::Paginate(30);
        }

        return view("admin.user.list", compact("users"));
    }

    // public function showUsersFiltered(Request $request)
    // {
    //     $params = $request->all();
    //     if ($params["stage"]) {
    //         $maxCourse = User::getCoursesByStage($params["stage"]);
    //         if ($params["course"] > $maxCourse) {
    //             $request["course"] = $maxCourse;
    //         }
    //     }
    //     return $this->showUsers($request);
    // }

    public function showUser(Request $request, $userId)
    {
        $user = User::find($userId);
        // dd($user->assignedWorkshop);
        return view("admin.user.details", compact("user"));
    }

    public function createUser()
    {
        return view("admin.user.create");
    }

    public function edituser($userId)
    {
        $user = User::find($userId);
        return view("admin.user.create", compact("user"));
    }

    public function storeUser()
    {
        $validated = request()->validate([
            "name" => "required",
            "surname" => "required",
            "email" => "required|email|unique:user,email",
            "stage" => "required",
            "course" => "required",
            "group" => "required",
        ], [
            "name.required" => "El camp nom és obligatori",
            "surname.required" => "El camp cognom és obligatori",
            "email.required" => "El camp email és obligatori",
            "email.email" => "El camp email ha de ser un email vàlid",
            "email.unique" => "Aquest email ja està registrat",
            "stage.required" => "El camp etapa és obligatori",
            "course.required" => "El camp curs és obligatori",
            "group.required" => "El camp grup és obligatori",
        ]);

        // check if input course corresponds to stage
        $maxCourse = User::getCoursesByStage($validated["stage"]);
        if ($validated["course"] > $maxCourse) {
            $validated["course"] = $maxCourse;
        }

        // grabbing user id from form and checking if exists. If exists, update, if not, create
        if (request()->input("id")) {
            $user = User::find(request()->input("id"));
            $user->update($validated);
            // return redirect()->route("adminShowUser", $user->id);
        } else {
            $user = User::create($validated);
            // return redirect()->route("adminShowUser", $user->id);
        }

        // $user = User::create($validated);
        return redirect()->route("adminShowUser", $user->id);
    }

    public function deleteUser()
    {
        $userId = request()->input("userId");
        $user = User::find($userId);
        $user->delete();
        return redirect()->route("adminShowUsers");
    }

    public function updateUserRole($userId)
    {
        $validated = request()->validate([
            "action" => "required",
        ], [
            "action.required" => "No s'ha trobat el rol",
        ]);

        $user = User::find($userId);

        switch ($validated["action"]) {
            case "makeAdmin":
                $user->authority = "Administrador";
                break;
            case "removeAdmin":
                $user->authority = "Usuari";
                break;
            case "makeStudent":
                $user->role = "Alumne";
                $user->authority = "Usuari";
                break;
            case "makeTeacher":
                $user->role = "Profesor";
                break;
        }
        $user->save();

        return redirect()->route("adminShowUser", $user->id);
    }

    public function selectWorkshop(Request $request, $userId)
    {
        $user = User::find($userId);
        $workshopChoiceType = request()->input("workshopChoiceType");
        // $workshops = Workshop::paginate(50)->appends(request()->query());
        $params = $request->all();
        if ($params) {
            $workshops = Workshop::query();

            foreach ($params as $field => $value) {
                if ($value == "") {
                    continue;
                }

                if (str_contains($field, "w_")) {
                    $field = str_replace("w_", "", $field);
                    if (method_exists(Workshop::class, "scope{$field}") && $value != "") {
                        $workshops = $workshops->$field($value);
                    }
                }

                if (str_contains($field, "u_")) {
                    $field = str_replace("u_", "User", $field);
                    if (method_exists(Workshop::class, "scope{$field}") && $value != "") {
                        $workshops = $workshops->$field($value);
                    }
                }
            }
            $workshops = $workshops->paginate(50)->appends(request()->query());
        } else {
            $workshops = Workshop::paginate(50)->appends(request()->query());
        }

        return view("admin.user.workshop-selection", compact("workshops", "workshopChoiceType", "user"));
    }

    public function storeWorkshopSelection($userId)
    {
        $workshopChoiceType = request()->input("workshopChoiceType");
        if (is_null($workshopChoiceType)) {
            return abort(500);
        }
        $workshopId = request()->input("workshopId");
        $user = User::find($userId);
        if ($user->workshopChoices === null) {
            $workshopChoices = new WorkshopChoice();
            $workshopChoices->user_id = $user->id;
        } else {
            $workshopChoices = $user->workshopChoices;
        }


        switch ($workshopChoiceType) {
            case 0:
                $workshopChoices->first_choice = $workshopId;
                break;
            case 1:
                $workshopChoices->second_choice = $workshopId;
                break;
            case 2:
                $workshopChoices->third_choice = $workshopId;
                break;
            case 3:
                $workshopChoices->assigned_workshop = $workshopId;
                // $user->assignedWorkshop = $workshopId;
                // $user->save();
                break;
        }

        $workshopChoices->save();
        // dd($workshopChoices);

        return redirect()->route("adminShowUser", $user->id);
    }
}
