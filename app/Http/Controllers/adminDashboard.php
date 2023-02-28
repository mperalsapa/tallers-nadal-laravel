<?php

namespace App\Http\Controllers;

use App\Models\AdminSetting;
use Illuminate\Http\Request;

class adminDashboard extends Controller
{
    public function index(Request $request)
    {
        $date = AdminSetting::where("name", "Inici de seleccio")->first()->value;
        // dd($setting->value);
        return view("admin.dashboard", compact("date"));
    }

    public function storeSetting(Request $request)
    {
        $validated = $request->validate([
            "setting" => "required",
            "submit" => "required",
        ], []);
        $setting = AdminSetting::where("name", $validated["submit"])->first();
        $setting->name = $validated["submit"];
        $setting->value = $validated["setting"];
        $setting->save();

        return redirect()->route("adminDashboardIndex");
    }
}
