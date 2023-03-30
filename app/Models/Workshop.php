<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Workshop
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property string|null $assistants
 * @property string $description
 * @property string|null $addressed_to
 * @property int $max_students
 * @property string $material
 * @property string|null $observations
 * @property string|null $place
 * @property string $created
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop query()
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop whereAddressedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop whereAssistants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop whereMaterial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop whereMaxStudents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop whereObservations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workshop whereUserId($value)
 * @mixin \Eloquent
 */
class Workshop extends Model
{
    use HasFactory;
    protected $table = 'workshop';
    protected $primaryKey = 'id';
    protected $fillable = ["name", "description", "addressed_to", "max_students", "material", "observations", "assistants", "place", "created", "manager"];
    // protected $casts = [
    //     'options' => 'json',
    // ];

    protected $multiselect = ["addressed_to"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function setAddressedToAttribute($value)
    {
        $this->attributes["addressed_to"] = json_encode($value);
    }

    public function getAddressedToAttribute($value)
    {
        return  json_decode($value, true);
    }

    public function getFreeStudents(): int
    {
        $userChoices = WorkshopChoice::where("first_choice", $this->id)
            ->orWhere("second_choice", $this->id)
            ->orWhere("third_choice", $this->id)->get();
        return $this->max_students - $userChoices->count();
    }

    public function scopeAddressedTo($query, $addressedTo)
    {
        return $query->where('addressed_to', 'like', '%' . $addressedTo . '%');
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    public function scopeStage($query, $stage)
    {
        return $query->where('addressed_to', 'like', '%' . $stage . '%');
    }

    public function scopeCourse($query, $course)
    {
        return $query->where('addressed_to', 'like', '%' . $course . '%');
    }

    // scope for the user that created the workshop, to match his name
    public function scopeUserName($query, $user)
    {
        // this cope checks for the user that created the workshop, to match his name
        $users = User::query()->name($user)->get();
        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = $user->id;
        }
        return $query->whereIn('user_id', $userIds);
    }

    // scope for user surname
    public function scopeUserSurname($query, $user)
    {
        // this cope checks for the user that created the workshop, to match his name
        $users = User::query()->surname($user)->get();
        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = $user->id;
        }
        return $query->whereIn('user_id', $userIds);
    }

    // scope for user stage
    public function scopeUserStage($query, $user)
    {
        // this cope checks for the user that created the workshop, to match his name
        $users = User::query()->stage($user)->get();
        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = $user->id;
        }
        return $query->whereIn('user_id', $userIds);
    }


    public function scopeUserCourse($query, $user)
    {
        // this cope checks for the user that created the workshop, to match his name
        $users = User::query()->course($user)->get();
        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = $user->id;
        }
        return $query->whereIn('user_id', $userIds);
    }


    public function scopeUserGroup($query, $user)
    {
        // this cope checks for the user that created the workshop, to match his name
        $users = User::query()->group($user)->get();
        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = $user->id;
        }
        return $query->whereIn('user_id', $userIds);
    }


    public function scopeUserRole($query, $user)
    {
        // this cope checks for the user that created the workshop, to match his name
        $users = User::query()->role($user)->get();
        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = $user->id;
        }
        return $query->whereIn('user_id', $userIds);
    }



    public function users()
    {
        return $this->belongsToMany(User::class, 'user_workshop_choice', 'assigned_workshop', 'user_id');
    }

    public function isFull(): bool
    {
        return $this->getFreeStudents() <= 0;
    }

    public function getLeastUsedWorkshopByCourseName(string $courseName): ?Workshop
    {
        $workshops = Workshop::withCount("users")->AddressedTo($courseName)->get()->sortBy("users_count");
        return $workshops->first();
    }
}
