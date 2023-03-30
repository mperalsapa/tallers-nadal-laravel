<?php

namespace Database\Seeders;

use App\Models\WorkshopChoice;
use Illuminate\Database\Seeder;

class WorkshopChoiceSeeder extends Seeder
{
    public function run()
    {
        WorkshopChoice::create([
            "user_id" => 1,
            "first_choice" => 1,
            "second_choice" => 3,
            "third_choice" => 4,
        ]);
        WorkshopChoice::create([
            "user_id" => 5,
            "first_choice" => 1,
            "second_choice" => 5,
            "third_choice" => 2,
        ]);
        WorkshopChoice::create([
            "user_id" => 6,
            "first_choice" => 8,
            "second_choice" => 6,
        ]);
        WorkshopChoice::create([
            "user_id" => 7,
            "first_choice" => 7,
        ]);
    }
}
