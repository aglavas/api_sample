<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(LocaleSeeder::class);
        $this->call(DietTypeSeeder::class);
        $this->call(MealTypeSeeder::class);
    }
}
