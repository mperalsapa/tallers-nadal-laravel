<?php

namespace App\Http\Controllers;

use App\Models\AdminSetting;
use App\Models\Workshop as ModelsWorkshop;
use App\Models\User;
use App\Models\WorkshopChoice;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class WorkShop extends Controller
{
    public function createWorkshop()
    {
        if (User::hasSelectWorkshopStarted() && !Auth::User()->isAdmin()) {
            session()->put("error", "Ja ha passat el periode per crear tallers. Si creus que això es un error, parla amb un professor.");
            return redirect()->route("index");
        }
        $workshop = Auth::user()->workshop;
        if ($workshop && !Auth::User()->isAdmin()) {
            return redirect()->route("editWorkshop", $workshop->id);
        }

        if (User::hasSelectWorkshopStarted() && !Auth::User()->isAdmin()) {
            return redirect()->route("index");
        }
        return view("workshop.create");
    }

    public function storeWorkshop(Request $request)
    {
        $validated = $request->validate([
            "name" => "required",
            "description" => "required",
            "material" => "required",
            "multiselect" => "required|array|min:1",
            "max_students" => "required|numeric|min:1|max:60",
            "submit" => "required",
        ], [
            "name.required" => "El titol del taller no pot ser buit.",
            "description.required" => "La descripció del taller no pot ser buida.",
            "material.required" => "El material del taller no pot ser buit.",
            "multiselect.required" => "No s'ha seleccionat una clase.",
            "multiselect.min" => "S'ha de seleccionar com a minim una clase.",
            "max_students.required" => "El numero de participants no pot ser buit.",
            "max_students.min" => "El numero minim de participants ha de ser com a minim de :min.",
            "max_students.max" => "El numero maxim de participants ha de ser com a molt de :max.",
            "submit.required" => "S'ha produit un error, contacta amb l'administrador."
        ]);

        $userCourse = Auth::User()->courseName();
        if (!in_array($userCourse, $validated["multiselect"]) && !Auth::User()->isTeacher()) {
            array_push($validated["multiselect"], $userCourse);
        }

        try {
            switch ($validated["submit"]) {
                case 'new':
                    $workshop = new ModelsWorkshop();
                    break;
                case 'update':
                    $workshop = ModelsWorkshop::findOrFail($request->input("workshop-id"));
                    break;
                case 'delete':
                    $workshop = ModelsWorkshop::findOrFail($request->input("workshop-id"));
                    $workshop->delete();
                    return redirect()->route("index");
                    break;

                default:
                    abort(500);
                    break;
            }
        } catch (ModelNotFoundException) {
            abort(404);
        }

        if (!isset($workshop->user_id)) {
            $workshop->user_id = Auth::User()->id;
        }
        $workshop->name = $validated["name"];
        $workshop->description = $validated["description"];
        $workshop->max_students = $validated["max_students"];
        $workshop->material = $validated["material"];
        $workshop->observations = $request->input("observation");
        if (!isset($workshop->created)) {
            $workshop->created = date("Y");
        }
        $workshop->addressed_to = $validated["multiselect"];
        if ($request->has("assistants")) {
            $workshop->assistants = $request->input("assistants");
        }
        if ($request->has("place")) {
            $workshop->place = $request->input("place");
        }
        if ($request->has("manager")) {
            $workshop->manager = $request->input("manager");
        } elseif (!Auth::User()->isAdmin()) {
            $workshop->manager = Auth::User()->name . " " . Auth::User()->surname;
        }

        $workshop->save();
        return redirect()->route("showWorkshop", $workshop->id);
    }

    public function showWorkshops(Request $request)
    {

        if (!Auth::User()->isTeacher()) {
            // dd(Auth::User()->courseName());
            // $workshops = ModelsWorkshop::query()->addressedTo(Auth::User()->courseName());
            // dd($workshops);
            $workshops = ModelsWorkshop::query()->addressedTo(Auth::User()->courseName())->paginate(25);
            return view("workshop.list", compact("workshops"));
        }


        $params = $request->all();

        if ($params) {
            $workshops = ModelsWorkshop::query();
            foreach ($params as $field => $value) {
                if (method_exists(ModelsWorkshop::class, "scope{$field}")) {
                    $workshops = $workshops->$field($value);
                }
            }
            $workshops = $workshops->paginate(25);
        } else {

            $workshops = ModelsWorkshop::Paginate(25);
        }


        return view("workshop.list", compact("workshops"));
    }

    public function showWorkshop($workshopId)
    {
        try {
            $workshop = ModelsWorkshop::findOrFail($workshopId);
        } catch (ModelNotFoundException) {
            abort(404);
        }
        $courseList = User::getCourseList();
        $userAsignedWorkshops = AdminSetting::getCheckedUserAsignedWorkshops();
        return view("workshop.details", compact("workshop", "courseList", "userAsignedWorkshops"));
    }

    public function editWorkshop($workshopId)
    {
        try {
            $workshop = ModelsWorkshop::findOrFail($workshopId);
        } catch (ModelNotFoundException) {
            abort(404);
        }
        if ($workshop->user_id == Auth::User()->id || Auth::User()->isTeacher()) {
            return view("workshop.create", compact("workshop"));
        }
        session()->put("error", "No pots modificar el taller d'un altre usuari");
        return redirect()->route("index");
    }

    public function selectWorkshop(Request $request)
    {
        $validated = $request->validate([
            "selection" => "required",
            "workshop_id" => "required",
        ]);
        // dd($validated);
        $user = User::find(Auth::User()->id);
        // dd($user);

        if ($user->workshopChoices === null) {
            $workshopChoices = new WorkshopChoice();
            $workshopChoices->user_id = $user->id;
        } else {
            $workshopChoices = $user->workshopChoices;
        }
        // dd($workshopChoices);
        switch ($validated["selection"]) {
            case 'first':
                $workshopChoices->first_choice = $validated["workshop_id"];
                $workshopChoices->save();
                break;
            case 'second':
                $workshopChoices->second_choice = $validated["workshop_id"];
                $workshopChoices->save();
                # code...
                break;
            case 'third':
                $workshopChoices->third_choice = $validated["workshop_id"];
                $workshopChoices->save();
                # code...
                break;
            case 'deselect':
                // set selected workshop to null based on workshop id and its array key from workshopChoicesId()
                // dd(array_search($validated["workshop_id"], Auth::User()->workshopChoicesId()));
                // dd($workshopChoices["first_choice"]);
                $workshopChoices[array_search($validated["workshop_id"], Auth::User()->workshopChoicesId())] = null;
                $workshopChoices->save();

                break;
            default:
                # code...
                break;
        }
        return redirect()->route("showWorkshop", $validated["workshop_id"]);
    }

    public function cloneWorkshop($workshopId)
    {
        $workshop = ModelsWorkshop::findOrFail($workshopId)->replicate();
        $workshop->user_id = Auth::User()->id;
        $workshop->save();
        return redirect()->route("showWorkshop", $workshop->id);
    }
}
