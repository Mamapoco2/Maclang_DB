<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions
        $permissions = [
            'division.manage',
            'department.manage',
            'employee.manage',
            'employee.view',
            'user.approve',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'SUPER_ADMIN']);
        $hr = Role::firstOrCreate(['name' => 'HR_MANAGER']);
        $head = Role::firstOrCreate(['name' => 'DEPARTMENT_HEAD']);
        $staff = Role::firstOrCreate(['name' => 'DEPARTMENT_STAFF']);

        // Assign permissions
        $superAdmin->givePermissionTo(Permission::all());

        $hr->givePermissionTo([
            'employee.manage',
            'employee.view',
            'user.approve'
        ]);

        $head->givePermissionTo([
            'employee.view'
        ]);

        $staff->givePermissionTo([
            'employee.view'
        ]);
    }
}
