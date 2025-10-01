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
            'post_view',
            'view_students',
            'create_students',
            'edit_students',
            'delete_students',
            // Teachers
            'view_teachers',
            'create_teachers',
            'edit_teachers',
            'delete_teachers',
            // Classes
            'view_classes',
            'create_classes',
            'edit_classes',
            'delete_classes',
            // Subjects
            'view_subjects',
            'create_subjects',
            'edit_subjects',
            'delete_subjects',
            // Grades
            'view_grades',
            'create_grades',
            'edit_grades',
            'delete_grades',
            // Attendances
            'view_attendances',
            'create_attendances',
            'edit_attendances',
            'delete_attendances',
            // Parents
            'view_parents',
            'create_parents',
            'edit_parents',
            'delete_parents',
        ];


        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
            // Permission::create(['name' => $permission]);

        }

        // Créer les rôles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $secretaryRole = Role::firstOrCreate(['name' => 'secretary']);

        // Assigner toutes les permissions à l'admin
        $adminRole->givePermissionTo(Permission::all());

        // Permissions pour les enseignants
        $teacherRole->givePermissionTo([
            'view_students',
            'view_grades',
            'create_grades',
            'edit_grades',
            'view_attendances',
            'create_attendances',
            'edit_attendances',
            'view_classes',
            'view_subjects'
        ]);

        // Permissions pour le secrétaire
        $secretaryRole->givePermissionTo([
            'view_students',
            'create_students',
            'edit_students',
            'view_parents',
            'create_parents',
            'edit_parents',
            'view_classes',
            'view_subjects',
            'view_attendances'
        ]);




        // // Création des rôles
        // $adminRole = Role::create(['name' => 'admin']);
        // $editorRole = Role::create(['name' => 'editor']);

        // Attribution des permissions aux rôles
        // $adminRole->givePermissionTo(Permission::all());

        // $editorPermissions = ['post_create', 'post_edit', 'post_delete', 'post_view'];
        // $editorRole->givePermissionTo($editorPermissions);

        // $userRole->givePermissionTo(['post_view']);

        // Créer un utilisateur admin
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
        ]);
        $admin->assignRole('admin');
    }
}