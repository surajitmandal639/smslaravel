<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
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
            ['name' => 'Guardian User', 'email' => 'guardian@example.com', 'roles' => ['guardian', 'teacher']],
            ['name' => 'User', 'email' => 'user@example.com', 'roles' => ['user']],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                ['name' => $userData['name'], 'password' => Hash::make('12345678')]
            );

            // Assign multiple roles from array
            $roleIds = Role::whereIn('name', $userData['roles'])->pluck('id')->toArray();

            // Always assign the "user" role as default if not already assigned
            $defaultRoleId = Role::where('name', 'user')->value('id');

            if (!in_array($defaultRoleId, $roleIds)) {
                $roleIds[] = $defaultRoleId;
            }

            $user->roles()->sync($roleIds);
        }
    }
}
