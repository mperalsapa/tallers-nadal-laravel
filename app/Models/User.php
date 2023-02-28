<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PhpParser\Node\Stmt\Switch_;

class User extends Authenticatable
{
    use HasFactory;
    protected $table = 'user';
    protected $primaryKey = 'id';

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
            "1BAT" => "1 BAT",
            "2BAT" => "2 BAT",
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
    public function taller()
    {
        return $this->hasOne(Taller::class);
    }
}
