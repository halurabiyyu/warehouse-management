<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Auth\Role;
use App\Models\DataPokok\Lecture;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'halurabiyyu@gmail.com',
            'username' => 'superadmin@mail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        Log::info(RoleEnum::SUPER_ADMIN->value);
        $superadmin = Role::where('name', RoleEnum::SUPER_ADMIN->value)->first();
        $user->assignRole($superadmin);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'username' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $adminRole = Role::where('name', RoleEnum::ADMIN->value)->first();
        $admin->assignRole($adminRole);

        $staff = User::create([
            'name' => 'Staff',
            'email' => 'staff@mail.com',
            'username' => 'staff@mail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $staffRole = Role::where('name', RoleEnum::STAFF->value)->first();
        $staff->assignRole($staffRole);
    }
}
