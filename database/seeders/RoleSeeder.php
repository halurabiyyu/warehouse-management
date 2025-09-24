<?php

namespace Database\Seeders;

use App\Models\Auth\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'superadmin',
                'guard_name' => 'web',
                'nice_name' => 'Super Admin',
            ],
            [
                'name' => 'admin',
                'guard_name' => 'web',
                'nice_name' => 'Admin',
            ],
            [
                'name' => 'staff',
                'guard_name' => 'web',
                'nice_name' => 'Staff',
            ]
        ];

        Role::query()->delete();

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name'], 'guard_name' => $role['guard_name']],
                ['nice_name' => $role['nice_name'], 'id' => \Illuminate\Support\Str::uuid()]
            );
        }
    }
}
