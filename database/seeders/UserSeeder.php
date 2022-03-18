<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

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
            'department_id' => 1,
            'name' => "Admin",
            'email' => "admin@gmail.com",
            'birth' => '2000-05-27',
            'password' =>  Hash::make('password')
        ]);

        $adminRole = Role::findByName(ROLES['ADMIN']);
        $admin->syncRoles($adminRole);

        $qam = User::create([
            'department_id' => 2,
            'name' => "QAM",
            'email' => "aqm@gmail.com",
            'birth' => '2000-05-27',
            'password' => Hash::make('password')
        ]);

        $qamRole = Role::findByName(ROLES['QAM']);
        $qam->syncRoles($qamRole);

        $qac = User::create([
            'department_id' => 3,
            'name' => "QAC",
            'email' => "aqc@gmail.com",
            'birth' => '2000-05-27',
            'password' => Hash::make('password')
        ]);

        $qacRole = Role::findByName(ROLES['QAC']);
        $qac->syncRoles($qacRole);

        $staff = User::create([
            'department_id' => 4,
            'name' => "STAFF",
            'email' => "staff@gmail.com",
            'birth' => '2000-05-27',
            'password' => Hash::make('password')
        ]);

        $staffRole = Role::findByName(ROLES['STAFF']);
        $staff->syncRoles($staffRole);
    }
}
