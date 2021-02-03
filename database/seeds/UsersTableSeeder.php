<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $subAdminRole = Role::where('name', 'subAdmin')->first();
        $userRole = Role::where('name', 'user')->first();

        $admin = User::create([
            'name' => 'Admin user',
            'email' => 'admin@admin.com',
            'password' => Hash::make('dats1234'),
        ]);

        $subAdmin = User::create([
            'name' => 'subAdmin user',
            'email' => 'subAdmin@subAdmin.com',
            'password' => Hash::make('dats1234'),
        ]);

        $user = User::create([
            'name' => 'Generic user',
            'email' => 'user@user.com',
            'password' => Hash::make('dats1234'),
        ]);

        $admin->roles()->attach($adminRole);
        $subAdmin->roles()->attach($adminRole);
        $user->roles()->attach($userRole);
    }
}
