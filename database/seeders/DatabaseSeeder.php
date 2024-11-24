<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            "name" => "Bob",
            "email" => "bob@gmail.com",
        ]);
        \App\Models\User::factory()->create([
            "name" => "Alice",
            "role_id" => 3,
            "email" => "alice@gmail.com",
        ]);
        \App\Models\User::factory()->create([
            "name" => "John",
            "email" => "john@gmail.com",
        ]);
        $roles = ['User', 'Manager', 'Admin'];
        foreach ($roles as $role) {
            \App\Models\Role::factory()->create([
                'role' => $role
            ]);
        }
    }
}
