<?php

namespace Database\Factories;

use App\Models\ClassRoom;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lecture>
 */
class LectureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user=User::whereHas('Role',function($query){
            $query->where('name','tutor');
        })->inRandomOrder()->first()->id;
        return [
            'course_id' => Course::inRandomOrder()->first()->id, // Replace with logic to get valid course_id
            'classroom_id' => ClassRoom::inRandomOrder()->first()->id, // Replace with logic to get valid classroom_id
            'tutor_id' => $user, // Replace with logic to get valid tutor_id
            'start_time' => $this->faker->dateTimeBetween('now', '+1 week'),
            'end_time' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
        ];
        // return [
        //     //
        // ];
    }
}
