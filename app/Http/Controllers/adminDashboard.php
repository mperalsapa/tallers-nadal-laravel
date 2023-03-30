<?php

namespace App\Http\Controllers;

use App\Models\AdminSetting;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopChoice;
use App\Models\WorkshopHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class adminDashboard extends Controller
{
    public function index(Request $request)
    {


        $activityPeriod = Carbon::now()->subHour()->getTimestamp();
        $recentActivityCount =
            DB::table('sessions')
            ->select('last_activity')
            ->where("last_activity", ">", $activityPeriod)
            ->count();

        $workshopCount = Workshop::count();

        $activeUserCount = DB::table('sessions')->count();

        // dd($setting->value);
        return view("admin.dashboard", compact("workshopCount", "activeUserCount", "recentActivityCount"));
    }


    public function showSettings()
    {
        $workshopStartDate = optional(AdminSetting::where("name", "startingDate")->first())->value;

        $workshopEndDate = optional(AdminSetting::where("name", "endingDate")->first())->value;

        $checkedUserAsignedWorkshops = AdminSetting::getCheckedUserAsignedWorkshops();

        $checkedUserChosedWorkshops = AdminSetting::getCheckedUserChoseWorkshops();

        return view("admin.settings", compact("workshopStartDate", "workshopEndDate", "checkedUserAsignedWorkshops", "checkedUserChosedWorkshops"));
    }

    public function storeSetting(Request $request)
    {
        $validated = $request->validate([
            "startingDate" => "required",
            "endingDate" => "required",
        ]);
        $startingDate = Carbon::createFromFormat("Y-m-d\TH:i", $validated["startingDate"]);
        $endingDate = Carbon::createFromFormat("Y-m-d\TH:i", $validated["endingDate"]);

        if ($startingDate->gte($endingDate)) {
            throw ValidationException::withMessages(['endingDate' => 'La data final ha de ser posterior a la data inicial']);
        }
        foreach ($validated as $option => $value) {

            $setting = AdminSetting::find($option);
            $setting->value = $validated[$option];
            $setting->save();
        }

        return redirect()->route("adminShowSetting");
    }

    public function runRoutine(Request $request)
    {
        // dd($request->input("submit"));
        switch ($request->input("submit")) {
            case 'storeWorkshops':
                return adminDashboard::storeWorkshops();
                break;
            case 'clearUsers':
                return adminDashboard::removeUsers();
                break;
            case 'importUsers':
                return adminDashboard::importUsers();
                break;
            case 'assignWorkshopUsers':
                return adminDashboard::assignWorkshopUsers();
                break;
            case 'forceAssignWorkshopUsers':
                return adminDashboard::forceAssignWorkshopUsers();
                break;
            case 'generateWorkshopChoiceReport':
                return adminDashboard::userChoicesReport();
                break;
            case 'generateWorkshopsMaterialsReport':
                return adminDashboard::workshopsMaterialsReport();
                break;
            case 'generateWorkshopUsersReport':
                return adminDashboard::workshopUsersReport();
                break;
            case 'clearChosedWorkshops':
                return adminDashboard::clearChosedWorkshops();
                break;
            case 'clearAssignedWorkshops':
                return adminDashboard::clearAssignedWorkshops();
                break;
            default:
                return abort(500);
                break;
        }
    }

    public function importUsers()
    {
        $userCreationLog = [];
        array_push($userCreationLog, "Fitxer d'importació: " . storage_path("usuaris.csv"));
        try {
            $file = fopen(storage_path("usuaris.csv"), "r");
        } catch (\Exception $e) {
            array_push($userCreationLog, "No s'ha trobat el fitxer d'importació. Abortant process d'importació");
            return view("admin.user.import", compact("userCreationLog"));
        }

        array_push($userCreationLog, "S'ha iniciat la importació d'usuaris.");
        while (!feof($file)) {

            $line = fgets($file);
            $userData = str_getcsv($line);
            if (count($userData) == 0) {
                continue;
            }

            $user = User::firstOrNew(["email" => $userData[0]]);

            $user->email = $userData[0];
            $user->stage = $userData[1];
            $user->course = $userData[2];
            $user->group = $userData[3];
            $user->surname = $userData[4];
            $user->name = $userData[5];

            if (!preg_match("/\..*@/", $user->email)) {
                $user->role = "Profesor";
            }

            try {
                $user->save();
            } catch (\Illuminate\Database\QueryException $e) {
                fclose($file);
                abort(500);
                // $errorCode = $e->errorInfo[1];
                // if ($errorCode == 1062) {
                //     array_push($userCreationLog, "S'ha trobat un usuari duplicat: " . $user->email . ". Ignorant usuari...");
                //     // echo "S'ha trobat un usuari duplicat: " . $user->email . "<br>";
                //     // } else { 
                //     // dd($e);
                // }
            }
        }

        fclose($file);

        array_push($userCreationLog, "S'ha finalitzat la importació d'usuaris correctament.");

        return view("admin.user.import", compact("userCreationLog"));
    }
    public function removeUsers()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (!$user->isSuperAdmin()) {
                $user->delete();
            }
        }
        return redirect()->route("adminShowSetting");
    }

    public function storeWorkshops()
    {
        $workshops = Workshop::all();

        foreach ($workshops as $workshop) {
            $workshopHistory = new WorkshopHistory();
            $workshopHistory->name = $workshop->name;
            $workshopHistory->description = $workshop->description;
            $workshopHistory->addressed_to = $workshop->addressed_to;
            $workshopHistory->max_students = $workshop->max_students;
            $workshopHistory->material = $workshop->material;
            $workshopHistory->observations = $workshop->observations;
            $workshopHistory->created = $workshop->created;
            $workshopHistory->creator = $workshop->user->name . " " . $workshop->user->surname;
            $workshopHistory->save();
            $workshop->delete();
        }
        $setting = AdminSetting::find("checkedUserAsignedWorkshops");
        $setting->value = 0;
        $setting->save();
        return redirect()->route("adminShowSetting");
    }


    public function assignWorkshopUsers()
    {
        $users = User::all();
        $usersWithoutWorkshop = array();
        $actionLog = array();
        foreach ($users as $user) {
            if (!$user->isSuperAdmin() && !$user->hasChoices()) {
                session()->put("error", "Un o mes alumnes no tenen totes les seleccions de taller. Alumne: " . $user->email);
                return redirect()->route("adminShowSetting");
            }
        }
        foreach ($users as $user) {
            if ($user->isSuperAdmin()) {
                array_push($actionLog, "Ignorant usuari " . $user->email . " perque es super admin");
                continue;
            }
            if ($user->hasAssignedWorkshop()) {
                array_push($actionLog, "Ignorant usuari " . $user->email . " perque ja te un taller assignat");
                continue;
            }
            $workshops = Workshop::withCount("users")->get()->sortBy("users_count");
            $choices = $user->workshopChoices;

            $workshop1 = $workshops->where("id", $choices->first_choice)->first();
            $workshop2 = $workshops->where("id", $choices->second_choice)->first();
            $workshop3 = $workshops->where("id", $choices->third_choice)->first();

            foreach (array($workshop1, $workshop2, $workshop3) as $workshop) {
                if ($workshop->users_count < $workshop->max_students) {
                    $choices->assigned_workshop = $workshop->id;
                    $choices->save();
                    array_push($actionLog, "El taller " . $workshop->name . " te " . $workshop->users_count . "/" . $workshop->max_students . ". Assignat usuari " . $user->email . " en aquest taller.");
                    // delete user from $usersWithoutWorkshop array if exists
                    $usersWithoutWorkshop = array_diff($usersWithoutWorkshop, array($user->email));
                    // if ($user->email == "") {
                    //     dd($choices, $workshop1, $workshop2, $workshop3);
                    // }
                    break;
                } else {
                    array_push($actionLog, "El taller " . $workshop->name . " te " . $workshop->users_count . "/" . $workshop->max_students . ". L'usuari " . $user->email . " no cap en aquest taller.");
                    array_push($usersWithoutWorkshop, $user->email);
                }
            }
            if ($choices->assigned_workshop == null) {
                array_push($actionLog, "L'usuari " . $user->email . " no s'ha pogut assignar a cap taller.");
            }
        }

        if (count($usersWithoutWorkshop) > 0) {
            return view("admin.log", compact("actionLog"))->with("error", "No s'han pogut assignar tots els usuaris. Comprova que hi ha tallers suficients i que no son plens.");
        } else {
            AdminSetting::setCheckedUserAsignedWorkshops(true);
            // return view("admin.log", compact("actionLog"))->with("error", "No s'han pogut assignar tots els usuaris. Comprova que hi ha tallers suficients i que no son plens.");
            return redirect()->route("adminShowSetting")->with("success", "S'han assignat correctament els tallers.");
        }
    }

    public function forceAssignWorkshopUsers()
    {
        $users = User::all();

        foreach ($users as $user) {
            if ($user->isSuperAdmin()) {
                continue;
            }

            if (!$user->hasChoices()) {
                $choices = new WorkshopChoice();
            } else {
                continue;
                // $choices = $user->workshopChoices;
            }

            $workshops = Workshop::withCount("users")->AddressedTo($user->courseName())->get()->sortBy("users_count");
            if ($workshops->count() < 3) {
                return redirect()->route("adminShowSetting")->with("error", "No hi ha prou tallers per assignar eleccions als usuaris. Comprova que hi ha tallers suficients i que no son plens. Usuari sense assignar: " . $user->email . "");
            }

            $workshop1 = $workshops->first();
            $workshop2 = $workshops->skip(1)->first();
            $workshop3 = $workshops->skip(2)->first();

            $choices->first_choice = $workshop1->id;
            $choices->second_choice = $workshop2->id;
            $choices->third_choice = $workshop3->id;
            $choices->user_id = $user->id;
            $choices->save();
        }

        return adminDashboard::assignWorkshopUsers();
    }



    // reports
    public function userChoicesReport()
    {
        $choices = WorkshopChoice::all();
        return view("admin.reports.userChoices", compact("choices"));
    }

    public function workshopUsersReport()
    {
        $workshops = Workshop::all();
        return view("admin.reports.workshopUsers", compact("workshops"));
    }

    public function workshopsMaterialsReport()
    {
        $workshops = Workshop::all();
        return view("admin.reports.workshopsMaterials", compact("workshops"));
    }

    public function clearChosedWorkshops()
    {
        $choices = WorkshopChoice::all();
        foreach ($choices as $choice) {
            $choice->first_choice = null;
            $choice->second_choice = null;
            $choice->third_choice = null;
            $choice->save();
        }

        AdminSetting::setCheckedUserChoseWorkshops(false);
        adminDashboard::clearAssignedWorkshops();
        return redirect()->route("adminShowSetting")->with("success", "S'han esborrat totes les seleccions de tallers correctament.");
    }

    public function clearAssignedWorkshops()
    {
        $choices = WorkshopChoice::all();
        foreach ($choices as $choice) {
            $choice->assigned_workshop = null;
            $choice->save();
        }

        AdminSetting::setCheckedUserAsignedWorkshops(false);
        return redirect()->route("adminShowSetting")->with("success", "S'han esborrat totes les assignacions de tallers correctament.");
    }
}
