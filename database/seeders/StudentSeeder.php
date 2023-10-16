<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(1000)->create()->each(function ($user) {
            $studentRole = Role::where('name', 'student')->first();

            if ($studentRole) {
                $user->Role()->attach($studentRole);
            }
        });
        //
    }
}
