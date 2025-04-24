<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'name' => $this->faker->name,
            'username' => $this->faker->userName,
            'date_of_birth' => $this->faker->date('Y-m-d', '2005-01-01'),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'phone' => $this->faker->unique()->numerify('##########'),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => 'India',
            'zip' => $this->faker->postcode,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
