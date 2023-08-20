<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'item-list',
            'item-create',
            'item-edit',
            'item-delete',
            'tmasuk-list',
            'tmasuk-create',
            'tmasuk-edit',
            'tmasuk-delete',
            'tkeluar-list',
            'tkeluar-create',
            'tkeluar-edit',
            'tkeluar-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
