<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdminSetting
 *
 * @property int $id
 * @property string $name
 * @property string $fancyName
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AdminSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminSetting whereFancyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminSetting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminSetting whereValue($value)
 * @mixin \Eloquent
 */
class AdminSetting extends Model
{
    use HasFactory;

    protected $table = "admin_setting";
    protected $primaryKey = "name";
    protected $keyType = 'string';
    protected $fillable = ["value"];

    // public function getValueAttribute($value)
    // {
    //     // if ($this->name == "Inici de seleccio") {
    //     //     return Carbon::createFromFormat("Y-m-d", $value)->toDateString();
    //     // }
    //     return $value;
    // }

    // public function setValueAttribute($value)
    // {
    //     // if ($this->name == "Inici de seleccio") {
    //     //     // dd(Carbon::createFromFormat("Y-m-d", $value));
    //     //     return $this->attributes["value"] = Carbon::createFromFormat("Y-m-d", $value)->toDateString();
    //     // }
    //     return $this->attributes["value"] = $value;
    // }

    public static function getStartSelectWorkshopDate()
    {
        return AdminSetting::where("name", "startingDate")->first()->value;
    }
    public static function getEndSelectWorkshopDate()
    {
        return AdminSetting::where("name", "endingDate")->first()->value;
    }
    public static function hasSelectWorkshopStarted()
    {
        $selectionDate = AdminSetting::where("name", "startingDate")->first()->value;
        // dd($selectionDate);
        $selectionDate = Carbon::createFromFormat("Y-m-d\TH:i", $selectionDate);
        // dd($selectionDate);
        $today = Carbon::now();
        // dd($today);

        return $today->gte($selectionDate);
    }

    public static function hasSelectWorkshopEnded()
    {
        $selectionDate = AdminSetting::where("name", "endingDate")->first()->value;
        // dd($selectionDate);
        $selectionDate = Carbon::createFromFormat("Y-m-d\TH:i", $selectionDate);
        // dd($selectionDate);
        $today = Carbon::now();
        // dd($today);
        // dd($today->gte($selectionDate));
        return $today->gte($selectionDate);
    }

    public static function isSelectWorkshopPeriod(): bool
    {
        return AdminSetting::hasSelectWorkshopStarted() && !AdminSetting::hasSelectWorkshopEnded();
    }

    public static function getCheckedUserAsignedWorkshops()
    {
        return AdminSetting::where("name", "checkedUserAsignedWorkshops")->first()->value;
    }

    public static function setCheckedUserAsignedWorkshops(bool $value)
    {
        $setting = AdminSetting::where("name", "checkedUserAsignedWorkshops")->first();
        $setting->value = $value ? "1" : "0";
        $setting->save();
    }
    public static function getCheckedUserChoseWorkshops()
    {
        return AdminSetting::where("name", "checkedUserChoseWorkshops")->first()->value;
    }

    public static function setCheckedUserChoseWorkshops(bool $value)
    {
        $setting = AdminSetting::where("name", "checkedUserChoseWorkshops")->first();
        $setting->value = $value ? "1" : "0";
        $setting->save();
    }
}
