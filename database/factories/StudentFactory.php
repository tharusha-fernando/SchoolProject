<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    public function definition(): array
    {

        // $user=User::whereHas('Role',function($query){
        //     $query->where('name','student');
        // })->inRandomOrder()->first();
        return [
            // 'user_id'=>$user->id,
            'gender'=> $this->faker->randomElement(['male', 'female','Non-Binary','Trans','Rather Not Say']),
            'dob'=>fake()->date(),
            'pronounce'=>$this->faker->randomElement(['he/him', 'she/her','they/them','Rather Not Say']),
            'address'=>fake()->address(),
            'tp'=>fake()->phoneNumber()
            //
        ];
    }
}
