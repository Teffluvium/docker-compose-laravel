<?php

namespace Database\Seeders;

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
        // DB::table('users')->insert([
        //     'name'              => 'Tim',
        //     'email'             => 'tim@test.com',
        //     'password'          => Hash::make('11111111'),
        //     'email_verified_at' => now(),
        //     'remember_token' => Str::random(10),
        // ]);

        // Seed with some additional random users
        $userCount = 3;
        \App\Models\User::factory()->count($userCount)->create();
    }
}
