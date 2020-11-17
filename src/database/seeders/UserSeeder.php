<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'              => 'Tim',
            'email'             => 'tim@test.com',
            'password'          => Hash::make('11111111'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // Seed with some additional random users
        $userCount = 3;
        $users = User::factory()->count($userCount)->create();

        // Create a personal team for each user
        $users = User::get();
        foreach ($users as $user) {
            // Grab user info
            $teamInfo = [
                'user_id' => $user,
                'name' => explode(' ', $user->name, 2)[0]."'s Team",
                'personal_team' => true,
            ];
            // Create the personal team
            $team = Team::factory()->create( $teamInfo );
        }
    }
}
