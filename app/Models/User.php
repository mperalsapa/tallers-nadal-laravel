<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;



/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $surname
 * @property string $email
 * @property string|null $stage
 * @property int|null $course
 * @property string|null $group
 * @property string $role
 * @property string $authority
 * @property int|null $choosedWorshop
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Workshop|null $workshop
 * @property-read \App\Models\WorkshopChoice|null $workshopChoices
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Workshop> $workshops
 * @property-read int|null $workshops_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAuthority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereChoosedWorshop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory;
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $filters = ["in"];
    protected $fillable = ["name", "surname", "email", "stage", "course", "group", "role", "authority", "assignedWorkshop"];

    public function fullCourseName(): string
    {
        $courseName = $this->course . " " . $this->stage . " " . $this->group;
        return $courseName;
    }
    public function courseName(): string
    {
        $courseName = $this->course . $this->stage;
        return $courseName;
    }

    public function fancyCourseName(): string
    {
        return $this->course . " " . $this->stage;
    }

    public static function getCourseList(): array
    {
        return array(
            "1ESO" => "1 ESO",
            "2ESO" => "2 ESO",
            "3ESO" => "3 ESO",
            "4ESO" => "4 ESO",
            "1BATX" => "1 BATX",
            "2BATX" => "2 BATX",
            "1FPB" => "1 FPB",
            "2FPB" => "2 FPB",
            "1SMX" => "1 SMX",
            "2SMX" => "2 SMX",
            "1ASIX" => "1 ASIX",
            "2ASIX" => "2 ASIX",
            "1DAW" => "1 DAW",
            "2DAW" => "2 DAW",
        );
    }

    public static function getStageList(): array
    {
        return array("ESO", "BATX", "FPB", "SMX", "ASIX", "DAW");
    }
    public static function getCoursesByStage($stage): int
    {
        $stages = User::getStageList();
        switch ($stage) {
            case $stages[0]:
                return 4;
                break;
            case $stages[1]:
                return 2;
                break;
            case $stages[2]:
                return 2;
                break;
            case $stages[3]:
                return 2;
                break;
            case $stages[4]:
                return 2;
                break;
            case $stages[5]:
                return 2;
                break;

            default:
                return null;
                break;
        }
    }
    public static function getGroupList(): array
    {
        return array("A", "B", "C", "D", "E", "F");
    }



    private function getAuthorizationId(string $authorization): int
    {
        switch ($authorization) {
            case 'Usuari':
                return 0;
                break;
            case 'Administrador':
                return 1;
                break;
            case 'Super Administrador':
                return 2;
                break;
            default:
                return -1;
                break;
        }
    }

    private function getRoleId(string $role): int
    {
        switch ($role) {
            case "Alumne":
                return 0;
                break;
            case "Profesor":
                return 1;
                break;
            default:
                return -1;
                break;
        }
    }

    public function isAdmin(): bool
    {
        $authorizationType = $this->getAuthorizationId($this->authority);
        if ($authorizationType > 0) {
            return true;
        }
        return false;
    }

    public function isSuperAdmin(): bool
    {
        $authorizationType = $this->getAuthorizationId($this->authority);
        if ($authorizationType == 2) {
            return true;
        }
        return false;
    }

    // La funció "isTeacher()" comprova si l'usuari actual és un professor. 
    // Si és així, retorna "true"; sinó, retorna "false". Això es fa comparant 
    // el valor del camp "role" de l'objecte d'usuari amb la funció "getRoleId()",
    //  que retorna un enter que representa el rol de l'usuari.
    public function isTeacher(): bool
    {
        $roleType = $this->getRoleId($this->role);
        if ($roleType == 1) {
            return true;
        }
        return false;
    }

    // public function workshop()
    // {
    //     return $this->hasOne(Workshop::class);
    // }

    public function workshop()
    {
        return $this->hasOne(Workshop::class);
    }

    public function workshops()
    {
        return $this->hasMany(Workshop::class);
    }

    public function workshopChoices()
    {
        return $this->hasOne(WorkshopChoice::class);
    }
    public function workshopChoicesId()
    {
        // dd($this->firstWorkshopChoice->id);
        $choices = array(
            "first_choice" => optional($this->firstWorkshopChoice)->id,
            "second_choice" => optional($this->secondWorkshopChoice)->id,
            "third_choice" => optional($this->thirdWorkshopChoice)->id
        );
        // $choices = array(user::firstWorkshopChoice()->id, user::secondWorkshopChoice()->id, user::thirdWorkshopChoice()->id);
        return $choices;
    }

    public function firstWorkshopChoice()
    {
        return $this->hasOneThrough(
            Workshop::class,
            WorkshopChoice::class,
            "user_id", // Nom de la clau forana a la taula workshop_choices
            "id", // Nom de la clau primària a la taula workshops
            "id", // Nom de la clau primària a la taula users
            "first_choice" // Nom del camp de la taula workshop_choices que fa referència al model Workshop
        );
    }
    public function secondWorkshopChoice()
    {
        return $this->hasOneThrough(
            Workshop::class,
            WorkshopChoice::class,
            "user_id", // Nom de la clau forana a la taula workshop_choices
            "id", // Nom de la clau primària a la taula workshops
            "id", // Nom de la clau primària a la taula users
            "second_choice" // Nom del camp de la taula workshop_choices que fa referència al model Workshop
        );
    }
    public function thirdWorkshopChoice()
    {
        return $this->hasOneThrough(
            Workshop::class,
            WorkshopChoice::class,
            "user_id", // Nom de la clau forana a la taula workshop_choices
            "id", // Nom de la clau primària a la taula workshops
            "id", // Nom de la clau primària a la taula users
            "third_choice" // Nom del camp de la taula workshop_choices que fa referència al model Workshop
        );
    }

    public function assignedWorkshop()
    {
        return $this->hasOneThrough(
            Workshop::class,
            WorkshopChoice::class,
            "user_id", // Nom de la clau forana a la taula workshop_choices
            "id", // Nom de la clau primària a la taula workshops
            "id", // Nom de la clau primària a la taula users
            "assigned_workshop" // Nom del camp de la taula workshop_choices que fa referència al model Workshop
        );
    }

    public function hasChoices(): bool
    {
        // checking if user has choices and if they are not null
        return $this->workshopChoices()->exists() && $this->workshopChoices->first_choice != null && $this->workshopChoices->second_choice != null && $this->workshopChoices->third_choice != null;
    }

    public function hasAssignedWorkshop(): bool
    {
        return $this->assignedWorkshop()->exists();
    }

    public static function hasSelectWorkshopStarted(): bool
    {
        return AdminSetting::hasSelectWorkshopStarted();
    }

    public static function hasSelectWorkshopended(): bool
    {
        return AdminSetting::hasSelectWorkshopEnded();
    }

    public static function isSelectWorkshopPeriod(): bool
    {
        return AdminSetting::isSelectWorkshopPeriod();
    }


    // Scopes
    // Used to filter queries
    public function scopeName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }
    public function scopeSurname($query, $surname)
    {
        return $query->where('surname', 'like', '%' . $surname . '%');
    }

    public function scopeEmail($query, $email)
    {
        return $query->where('email', 'like', '%' . $email . '%');
    }

    public function scopeStage($query, $stage)
    {
        return $query->where('stage', 'like', '%' . $stage . '%');
    }

    public function scopeCourse($query, $course)
    {
        return $query->where('course', 'like', '%' . $course . '%');
    }

    public function scopeGroup($query, $group)
    {
        return $query->where('group', 'like', '%' . $group . '%');
    }

    public function scopeAuthority($query, $authority)
    {
        return $query->where('authority', 'like', '%' . $authority . '%');
    }

    public function scopeRole($query, $role)
    {
        return $query->where('role', 'like', '%' . $role . '%');
    }
}
