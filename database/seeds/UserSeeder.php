<?php

use Illuminate\Database\Seeder;

use App\Models\User\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => "Admin",
            'last_name' => "Admin",
            'email' => "admin@mail.com",
            'password' => "123456",
            'sex' => "male",
            'type' => 'admin',
            'locale' => 'en',
            'birth_date' => "1970-01-01",
            'verified' => 1
        ]);

        User::create([
            'first_name' => "Simple",
            'last_name' => "User",
            'email' => "simple.user@mail.com",
            'password' => "123456",
            'sex' => "male",
            'type' => 'user',
            'locale' => 'en',
            'birth_date' => "1970-01-01",
            'verified' => 1
        ]);

        User::create([
            'first_name' => "Admin",
            'last_name' => "Admin #2",
            'email' => "admin2@mail.com",
            'password' => "123456",
            'sex' => "male",
            'type' => 'admin',
            'locale' => 'en',
            'birth_date' => "1970-01-01",
            'verified' => 1
        ]);
    }
}
