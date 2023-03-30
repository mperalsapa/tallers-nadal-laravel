<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\WorkshopChoice
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $first_choice
 * @property int|null $second_choice
 * @property int|null $third_choice
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Workshop|null $firstChoice
 * @property-read \App\Models\Workshop|null $secondChoice
 * @property-read \App\Models\Workshop|null $thirdChoice
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Workshop|null $workshop
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopChoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopChoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopChoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopChoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopChoice whereFirstChoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopChoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopChoice whereSecondChoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopChoice whereThirdChoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopChoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkshopChoice whereUserId($value)
 * @mixin \Eloquent
 */
class WorkshopChoice extends Model
{
    use HasFactory;
    protected $table = 'user_workshop_choice';
    protected $primaryKey = 'id';
    protected $fillable = ["user_id", "first_choice", "second_choice", "third_choice"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    public function firstChoice()
    {
        return $this->belongsTo(Workshop::class, 'first_choice') ?? "";
    }

    public function secondChoice()
    {
        return $this->belongsTo(Workshop::class, 'second_choice') ?? "";
    }

    public function thirdChoice()
    {
        return $this->belongsTo(Workshop::class, 'third_choice') ?? "";
    }

    public function assigned()
    {
        return $this->belongsTo(Workshop::class, 'assigned_workshop') ?? "";
    }

    public function scopeAssigned($query, $assigned)
    {
        return $query->where('assigned_workshop', $assigned);
    }
}
