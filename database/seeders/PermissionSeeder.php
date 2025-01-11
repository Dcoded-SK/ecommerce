<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $permissions = ['view_users', 'view_orders', 'view_products', 'view_roles', 'add_genre', 'add_books', 'update_books'];

        foreach ($permissions as $per) {
            # code...

            Permission::create([
                'name' => $per
            ]);
        }
    }
}
