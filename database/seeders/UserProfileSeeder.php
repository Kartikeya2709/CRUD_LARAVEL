<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserProfile;
use App\Models\UserComment;

class UserProfileSeeder extends Seeder
{
    public function run(): void
    {
        UserProfile::factory()
            ->count(40000)  // You can adjust the count as needed
            ->create()
            ->each(function ($user) {
                // Create or update the comment for each user
                UserComment::firstOrCreate(
                    ['email' => $user->email],  // Check for duplicate email
                    [
                        'comment' => fake()->sentence(15),  // Random comment
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            });
    }
}
