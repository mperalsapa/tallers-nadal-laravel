<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    use HasFactory;

    protected $table = "admin_setting";
    protected $primaryKey = "id";
    protected $fillable = ["name", "value"];

    public function getValueAttribute($value)
    {
        // if ($this->name == "Inici de seleccio") {
        //     return Carbon::createFromFormat("Y-m-d", $value)->toDateString();
        // }
        return $value;
    }

    public function setValueAttribute($value)
    {
        // if ($this->name == "Inici de seleccio") {
        //     // dd(Carbon::createFromFormat("Y-m-d", $value));
        //     return $this->attributes["value"] = Carbon::createFromFormat("Y-m-d", $value)->toDateString();
        // }
        return $this->attributes["value"] = $value;
    }

    public static function getSelectTallerDate()
    {
        return AdminSetting::where("name", "Inici de seleccio")->first()->value;
        // return "HOLA";
    }

    public static function canSelectTaller()
    {
        $selectionDate = AdminSetting::where("name", "Inici de seleccio")->first()->value;
        // dd($selectionDate);
        $selectionDate = Carbon::createFromFormat("Y-m-d\TH:i", $selectionDate);
        // dd($selectionDate);
        $today = Carbon::now();
        // dd($today);

        return $today->gte($selectionDate);
        // return "HOLA";
    }
}
