<?php

use Illuminate\Database\Seeder;
use App\Models\Meal\MealType;

class MealTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MealType::create([
            'type' => "Breakfast",
        ]);

        MealType::create([
            'type' => "Lunch",
        ]);

        MealType::create([
            'type' => "Dinner",
        ]);
    }
}
