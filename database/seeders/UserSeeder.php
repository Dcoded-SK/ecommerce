<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {

            User::create([
                'name' => $faker->name(),
                'email' => $faker->email(),
                // 'role' => "supplier",
                // 'role' => 'admin',
                'password' => bcrypt('password'),
            ]);
        }
    }
}