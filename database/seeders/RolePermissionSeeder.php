<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Création des permissions
        $permissions = [
            'user_management',
            'role_management',
            'permission_management',
            'post_create',
            'post_edit',
            'post_delete',
            'post_view'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Création des rôles
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);
        $userRole = Role::create(['name' => 'user']);

        // Attribution des permissions aux rôles
        $adminRole->givePermissionTo(Permission::all());

        $editorPermissions = ['post_create', 'post_edit', 'post_delete', 'post_view'];
        $editorRole->givePermissionTo($editorPermissions);

        $userRole->givePermissionTo(['post_view']);

        // Créer un utilisateur admin
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('admin');
    }
}