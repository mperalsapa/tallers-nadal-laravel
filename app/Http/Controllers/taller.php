<?php

namespace App\Http\Controllers;

use App\Models\Taller as ModelsTaller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class taller extends Controller
{
    public function createTaller()
    {
        $taller = Auth::user()->taller;
        if (isset($taller->id)) {
            return redirect()->route("editTaller", $taller->id);
        }
        // $taller = User::with('taller')->find(14)->taller;

        // dd($taller);
        // dd($taller->addressed_to);

        return view("taller.create", compact("taller"));
    }

    public function storeTaller(Request $request)
    {
        // $userSelect = $request->get('multiselect');
        // dd($userSelect);
        // dd($request);
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
            "submid.required" => "S'ha produit un error, contacta amb l'administrador."
        ]);

        $userCourse = Auth::user()->courseName();
        if (!in_array($userCourse, $validated["multiselect"]) && count($validated["multiselect"]) < 1) {
            $validated["multiselect"][] = $userCourse;
        }

        switch ($validated["submit"]) {
            case 'new':
                $taller = new ModelsTaller();
                break;
            case 'update':
                $taller = ModelsTaller::find($request->input("taller-id"));
                break;
            case 'delete':
                $taller = ModelsTaller::find($request->input("taller-id"));
                $taller->delete();
                return redirect()->route("index");
                break;

            default:
                abort(500);
                break;
        }

        // if ($validated["submit"] == "new") {
        //     $taller = new ModelsTaller();
        // } else {
        //     $taller = User::find($validated["submit"])->taller;
        // }
        if (!isset($taller->user_id)) {
            $taller->user_id = Auth::User()->id;
        }
        $taller->name = $validated["name"];
        $taller->description = $validated["description"];
        $taller->max_students = $validated["max_students"];
        $taller->material = $validated["material"];
        $taller->observations = $request->input("observation");
        if (!isset($taller->created)) {
            $taller->created = today();
        }
        $taller->addressed_to = $validated["multiselect"];

        $taller->save();

        return redirect()->route("index");
    }

    public function showTallers()
    {
        $tallers = ModelsTaller::Paginate(3);
        return view("taller.list", compact("tallers"));
    }

    public function showTaller($tallerId)
    {
        $taller = ModelsTaller::find($tallerId);
        $courseList = User::getCourseList();
        return view("taller.details", compact("taller", "courseList"));
    }

    public function editTaller($tallerId)
    {
        $taller = ModelsTaller::find($tallerId);
        if ($taller->user_id == Auth::User()->id || Auth::User()->isTeacher()) {
            return view("taller.create", compact("taller"));
        }
        abort(403);
    }
}
