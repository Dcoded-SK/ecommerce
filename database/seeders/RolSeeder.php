<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $role = ["user", "admin", "supplier"];
        foreach ($role as $r) {
            # code...
            Role::create([
                'name' => $r
            ]);
        }
    }
}