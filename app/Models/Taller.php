<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    use HasFactory;
    protected $table = 'taller';
    protected $primaryKey = 'id';
    protected $fillable = ["name", "description", "addressed_to", "max_students", "material", "observations", "created"];
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
}
