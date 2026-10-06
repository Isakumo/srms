<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::where('code', 'demo-school')->firstOrFail();

        $roleDefinitions = [
            ['name' => 'Super Administrator', 'code' => 'super_administrator'],
            ['name' => 'School Administrator', 'code' => 'school_administrator'],
            ['name' => 'Principal / Head Teacher', 'code' => 'principal'],
            ['name' => 'Academic Officer', 'code' => 'academic_officer'],
            ['name' => 'Bursar / Accountant', 'code' => 'bursar'],
            ['name' => 'Teacher', 'code' => 'teacher'],
            ['name' => 'Parent / Guardian', 'code' => 'parent'],
            ['name' => 'Student', 'code' => 'student'],
        ];

        foreach ($roleDefinitions as $roleDefinition) {
            $role = Role::updateOrCreate(
                ['school_id' => $school->id, 'code' => $roleDefinition['code']],
                [
                    'name' => $roleDefinition['name'],
                    'description' => $roleDefinition['name'],
                    'is_system_role' => true,
                    'status' => 'ACTIVE',
                ]
            );

            if ($roleDefinition['code'] === 'super_administrator') {
                $permissions = Permission::pluck('id');
                $role->permissions()->sync($permissions);
            }
        }

        $admin = User::firstOrCreate([
            'username' => 'admin',
        ], [
            'school_id' => $school->id,
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'status' => 'ACTIVE',
            'must_change_password' => false,
        ]);

        $adminRole = Role::where('code', 'super_administrator')->first();
        $admin->roles()->syncWithoutDetaching($adminRole ? [$adminRole->id] : []);
    }
}
