<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workshop as ModelsWorkshop;
use App\Models\WorkshopHistory as ModelsWorkshopHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkShopHistory extends Controller
{
    public function showWorkshops()
    {
        $history = ModelsWorkshopHistory::paginate(20);
        // dd($history);

        return view("workshop_history.list", compact("history"));
    }


    public function showEditWorkshop()
    {
        return view("workshop.create", compact("workshop"));
    }
    public function editWorkshop(Request $request)
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
            "submid.required" => "S'ha produit un error, contacta amb l'administrador."
        ]);


        $workshop = ModelsWorkshopHistory::find($request->input("workshop-id"));



        $workshop->name = $validated["name"];
        $workshop->description = $validated["description"];
        $workshop->max_students = $validated["max_students"];
        $workshop->material = $validated["material"];
        $workshop->observations = $request->input("observation");
        if (!isset($workshop->created)) {
            $workshop->created = today();
        }
        $workshop->addressed_to = $validated["multiselect"];

        $workshop->save();
        return redirect()->route("showWorkshop", $workshop->id);
    }

    public function storeWorkshop(Request $request)
    {
        $validated = $request->validate([
            "workshopId" => "required",
            "submit" => "required",
        ]);

        $workshopId = $validated["workshopId"];
        $action = $validated["submit"];

        $workshop = ModelsWorkshopHistory::find($workshopId);

        switch ($action) {
            case 'copy':
                if (!Auth::User()->isAdmin()) {
                    $newWorkshop = Auth::User()->workshop()->first();
                    if (!isset($newWorkshop)) {
                        $newWorkshop = new ModelsWorkshop();
                    }
                } else {
                    $newWorkshop = new ModelsWorkshop();
                }

                $newWorkshop->user_id = Auth::User()->id;
                $newWorkshop->name = $workshop->name;
                $newWorkshop->description = $workshop->description;
                $newWorkshop->max_students = $workshop->max_students;
                $newWorkshop->material = $workshop->material;
                $newWorkshop->observations = $workshop->observation;
                $newWorkshop->created = date("Y");
                $newWorkshop->addressed_to = $workshop->addressed_to;
                $newWorkshop->save();

                return redirect()->route("showWorkshop", $newWorkshop->id);
                break;
            case 'remove':
                ModelsWorkshopHistory::destroy($workshopId);
                return redirect()->route("showWorkshopsHistory");
                break;
            case 'edit':
                return redirect()->route("editWorkshopHistory", $workshopId);
                break;
        }
    }

    public function showWorkshop($workshopId)
    {
        $workshop = ModelsWorkshopHistory::find($workshopId);
        $courseList = User::getCourseList();

        return view("workshop_history.details", compact("workshop", "courseList"));
    }
}
