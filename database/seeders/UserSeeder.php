<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Role;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => "Admin",
            'email' => "admin@gmail.com",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $adminRole = Role::findByName(ROLES['ADMIN']);
        $admin->syncRoles($adminRole);

        $qam = User::create([
            'name' => "QAM",
            'email' => "aqm@gmail.com",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $qamRole = Role::findByName(ROLES['QAM']);
        $qam->syncRoles($qamRole);

        $qac = User::create([
            'name' => "QAC",
            'email' => "aqc@gmail.com",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $qacRole = Role::findByName(ROLES['QAC']);
        $qac->syncRoles($qacRole);

        $staff = User::create([
            'name' => "STAFF",
            'email' => "staff@gmail.com",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $staffRole = Role::findByName(ROLES['STAFF']);
        $staff->syncRoles($staffRole);
    }
}
