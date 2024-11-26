<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
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
            "phone" => "09458923503",
            "address" => "123 Main Street, Anytown, CA 12345",
        ]);
        \App\Models\User::factory()->create([
            "name" => "Alice",
            "role_id" => 3,
            "email" => "alice@gmail.com",
            "phone" => "09458943503",
            "address" => "456 Elm Street, Suite 3, Los Angeles",
        ]);
        \App\Models\User::factory()->create([
            "name" => "John",
            "role_id" => 2,
            "email" => "john@gmail.com",
            "phone" => "09258943503",
            "address" => "49 Featherstone Street, LONDON, EC1Y 8SY",
        ]);
        \App\Models\User::factory()->create([
            "name" => "Elle",
            "email" => "elle@gmail.com",
            "phone" => "09458943503",
            "address" => "456 Elm Street, Suite 3, Los Angeles",
        ]);
        \App\Models\User::factory()->create([
            "name" => "Oliver",
            "email" => "oliver@gmail.com",
            "phone" => "09458943503",
            "address" => "456 Elm Street, Suite 3, Los Angeles",
        ]);
        $roles = ['User', 'Manager', 'Admin'];
        foreach ($roles as $role) {
            \App\Models\Role::factory()->create([
                'role' => $role
            ]);
        }
        $permissions = ['user-create', 'user-read', 'user-update', 'user-delete', 'user-suspended'];
        foreach ($permissions as $permission) {
            Permission::create([
                'permissions' => $permission
            ]);
        }
    }
}
