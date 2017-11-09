<?php

use Illuminate\Database\Seeder;
use App\Models\Meal\DietType;

class DietTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DietType::create([
            'type' => "Vegetarian",
        ]);


        DietType::create([
            'type' => "Vegan",
        ]);

        DietType::create([
            'type' => "Regular",
        ]);
    }
}
