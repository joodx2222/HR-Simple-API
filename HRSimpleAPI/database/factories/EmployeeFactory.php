<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=> $this->faker->name(),
            'age'=> $this->faker->numberBetween(18, 50),
            'salary'=> $this->faker->numberBetween(1600, 2500),
            'gender'=> $this->faker->randomElement(['Male', 'Female']),
            'hiredDate'=> $this->faker->dateTime(),
            'jobTitle'=> $this->faker->text(24)
        ];
    }
}
