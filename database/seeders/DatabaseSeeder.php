<?php

namespace Database\Seeders;

use App\Models\Lecture;
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
        // $this->call(RoleSeeder::class);

        $this->call(LaratrustSeeder::class);

        $user= User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@material.com',
            'password' => ('secret')
        ]);

        $user->addRole('superadministrator'); // parameter can be a Role object, BackedEnum, array, id or the role string name
        

        $user= User::factory()->create([
            'name' => 'Tutor',
            'email' => 'tutor@material.com',
            'password' => ('secret')
        ]);
        $user->addRole('tutor');


        $user= User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@material.com',
            'password' => ('secret')
        ]);
        $user->addRole('administrator');

        

        $user= User::factory()->create([
            'name' => 'Student',
            'email' => 'student@material.com',
            'password' => ('secret')
        ]);
        $user->addRole('student');


        $this->call(StudentSeeder::class);
        $this->call(TutorSeeder::class);

        $this->call(CourseSeeder::class);

        $this->call(ClassRoomSeeder::class);
        $this->call(LectureSeeder::class);

    
    }
}
