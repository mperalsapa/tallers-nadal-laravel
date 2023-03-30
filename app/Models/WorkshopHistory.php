<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WorkshopHistory
 *
 * @property int $id
 * @property string $name
 * @property string $creator
 * @property string $description
 * @property string|null $addressed_to
 * @property int $max_students
 * @property string $material
 * @property string|null $observations
 * @property string $created
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopHistory whereAddressedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopHistory whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopHistory whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopHistory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopHistory whereMaterial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopHistory whereMaxStudents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopHistory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopHistory whereObservations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WorkshopHistory extends Model
{
    use HasFactory;
    protected $table = 'workshop_history';
    protected $primaryKey = 'id';
    public function setAddressedToAttribute($value)
    {
        $this->attributes["addressed_to"] = json_encode($value);
    }

    public function getAddressedToAttribute($value)
    {
        return  json_decode($value, true);
    }
}
