<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\UserProfileFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserComment>
 */
class UserCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => UserProfileFactory::new()->create()->email,
            'comment' => fake()->realText(200), // Generate a realistic English paragraph
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
