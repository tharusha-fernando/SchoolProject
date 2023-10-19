<?php

namespace Database\Seeders;

use App\Models\Lecture;
use App\Models\Role;
use App\Models\Student;
use App\Models\Tutors;
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
        Tutors::factory()->create(['user_id'=>$user->id]);


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
        Student::factory()->create(['user_id'=>$user->id]);



        $this->call(StudentSeeder::class);
        $this->call(TutorSeeder::class);

        $this->call(CourseSeeder::class);

        $this->call(ClassRoomSeeder::class);
        $this->call(LectureSeeder::class);

    
    }
}
