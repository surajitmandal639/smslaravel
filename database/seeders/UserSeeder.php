<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Admin User', 'email' => 'admin@example.com', 'roles' => ['admin', 'teacher']],
            ['name' => 'Student User', 'email' => 'student@example.com', 'roles' => ['student']],
            ['name' => 'Teacher User', 'email' => 'teacher@example.com', 'roles' => ['teacher', 'staff']],
            ['name' => 'Staff User', 'email' => 'staff@example.com', 'roles' => ['staff']],
            ['name' => 'Guardian User', 'email' => 'guardian@example.com', 'roles' => ['guardian']],
            ['name' => 'Public User', 'email' => 'public@example.com', 'roles' => ['public', 'student']],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                ['name' => $userData['name'], 'password' => Hash::make('12345678')]
            );

            // Assign multiple roles
            $roleIds = Role::whereIn('name', $userData['roles'])->pluck('id');
            $user->roles()->sync($roleIds);
        }
    }
}
