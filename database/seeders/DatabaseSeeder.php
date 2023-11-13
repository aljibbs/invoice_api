<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'description' => 'A User who is an admin'],
            ['name' => 'sales', 'description' => 'A User who is in sales'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
