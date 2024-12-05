<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use App\Models\Role;
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
            "address" => "123 Main Street, Anytown",
        ]);
        \App\Models\User::factory()->create([
            "name" => "Alice",
            "role_id" => 3,
            "email" => "alice@gmail.com",
            "phone" => "09458943503",
            "address" => "Nay Pyi Taw",
        ]);
        \App\Models\User::factory()->create([
            "name" => "John",
            "role_id" => 2,
            "email" => "john@gmail.com",
            "phone" => "09258943503",
            "address" => "Pyin Oo Lwin",
        ]);
        \App\Models\User::factory()->create([
            "name" => "Elle",
            "email" => "elle@gmail.com",
            "phone" => "09458943503",
            "address" => "Mandalay",
        ]);
        \App\Models\User::factory()->create([
            "name" => "Oliver",
            "email" => "oliver@gmail.com",
            "phone" => "09458943503",
            "address" => "Taung Gyi",
        ]);
        \App\Models\User::factory()->create([
            "name" => "Sonia",
            "email" => "sonia@gmail.com",
            "phone" => "09458943503",
            "address" => "Yangon",
        ]);
        \App\Models\User::factory()->create([
            "name" => "Adam",
            "email" => "adam@gmail.com",
            "phone" => "09458943503",
            "address" => "Dala",
        ]);
        \App\Models\User::factory()->create([
            "name" => "Johnny",
            "email" => "johnny@gmail.com",
            "phone" => "09458943503",
            "address" => "Santa Cruz",
        ]);
        \App\Models\User::factory()->create([
            "name" => "Mavis",
            "email" => "mavis@gmail.com",
            "phone" => "09458943503",
            "address" => "Transylvania",
        ]);
        $roles = ['User', 'Manager', 'Admin'];
        foreach ($roles as $role) {
            \App\Models\Role::factory()->create([
                'role' => $role
            ]);
        }
        $permissions = ['user-create', 'user-read', 'user-update', 'user-delete', 'user-suspended', 'change-role'];
        foreach ($permissions as $permission) {
            Permission::create([
                'permissions' => $permission
            ]);
        }
        $adminRole = Role::where('role', 'Admin')->first();
        $managerRole = Role::where('role', 'Manager')->first();
        $userRole = Role::where('role', 'User')->first();
        if ($adminRole) {
            $adminRole->permissions()->attach(Permission::all());
        }
        $managerRolePermission = Permission::whereIn('permissions', ['user-read', 'user-suspended'])->get();
        if($managerRole && $managerRolePermission) {
            $managerRole->permissions()->attach($managerRolePermission->pluck('id'));
        }
        $userReadPermission = Permission::where('permissions', 'user-read')->first();
        if ($userRole && $userReadPermission) {
            $userRole->permissions()->attach($userReadPermission->id);
        }
    }
}
