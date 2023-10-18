<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Tutors;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(20)->create()->each(function ($user) {
            $user->addRole('tutor');

            Tutors::factory()->create(['user_id'=>$user->id]);

        });
        //
    }
}
