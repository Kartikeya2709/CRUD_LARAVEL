<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserProfile; // Assuming you have the UserProfile model
use App\Models\UserComment; // Assuming you have the UserComment model
use Faker\Factory as Faker;

class UserCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all user profiles (emails)
        $userProfiles = UserProfile::all();

        // Loop through each user profile and create a comment if it doesn't exist
        foreach ($userProfiles as $profile) {
            UserComment::firstOrCreate(
                ['email' => $profile->email],  // Check if comment exists for this email
                [
                    'comment' => fake()->realText(200),  // Generate a realistic English paragraph
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
