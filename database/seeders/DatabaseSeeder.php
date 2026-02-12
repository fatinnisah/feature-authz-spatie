<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------
        // Create Permissions
        // ---------------------------
        $permissions = [
            'create-documents',
            'view-documents',
            'edit-documents',
            'delete-documents',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ---------------------------
        // Create Roles
        // ---------------------------
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $viewerRole = Role::firstOrCreate(['name' => 'viewer']);

        // Assign permissions
        $adminRole->givePermissionTo(Permission::all());
        $managerRole->givePermissionTo([
            'create-documents',
            'view-documents',
            'edit-documents',
        ]);
        $viewerRole->givePermissionTo([
            'view-documents',
        ]);

        // ---------------------------
        // Create Users
        // ---------------------------
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),

        ]);
        $admin->assignRole('admin');

        $editor = User::factory()->create([
            'name' => 'Editor User',
            'email' => 'editor@mail.com',
        ]);
        $editor->assignRole('manager');

        $viewer = User::factory()->create([
            'name' => 'Viewer User',
            'email' => 'viewer@mail.com',
        ]);
        $viewer->assignRole('viewer');
    }
}
