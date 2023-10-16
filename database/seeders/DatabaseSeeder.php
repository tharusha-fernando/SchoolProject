<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);

        $user= User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@material.com',
            'password' => ('secret')
        ]);
        $role = Role::where('name', 'admin')->first(); // Assuming 'admin' is the role name you want to attach

        $user->Role()->attach($role);
        

        $user= User::factory()->create([
            'name' => 'Tutor',
            'email' => 'tutor@material.com',
            'password' => ('secret')
        ]);
        $role = Role::where('name', 'tutor')->first(); // Assuming 'admin' is the role name you want to attach

        $user->Role()->attach($role);


        $user= User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@material.com',
            'password' => ('secret')
        ]);
        $role = Role::where('name', 'admin')->first(); // Assuming 'admin' is the role name you want to attach

        $user->Role()->attach($role);
        

        $user= User::factory()->create([
            'name' => 'Student',
            'email' => 'student@material.com',
            'password' => ('secret')
        ]);
        $role = Role::where('name', 'student')->first(); // Assuming 'admin' is the role name you want to attach

        $user->Role()->attach($role);
        


    }
}
