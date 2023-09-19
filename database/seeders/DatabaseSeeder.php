<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use \App\Models\User;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Use your own email addresses to check for email notifications for each user
     */
    public function run(): void
    {
        User::create([
            'name' => 'Isabella Anderson',
            'email' => 'hello@adamriaz.com',
            'password' => Hash::make('secret'),
            'organisation' => 'CompanyOne',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);

        User::create([
            'name' => 'Liam Parker',
            'email' => 'tester1@adamriaz.com',
            'password' => Hash::make('password321'),
            'organisation' => 'CompanyOne',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);

        User::create([
            'name' => 'Sophia Ramirez',
            'email' => 'tester2@adamriaz.com',
            'password' => Hash::make('secretcode'),
            'organisation' => 'CompanyTwo',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);

        User::create([
            'name' => 'Ethan Anderson',
            'email' => 'tester3@adamriaz.com',
            'password' => Hash::make('mysecretcode123'),
            'organisation' => 'CompanyTwo',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);

        User::create([
            'name' => 'Liam Anderson',
            'email' => 'tester4@adamriaz.com',
            'password' => Hash::make('youalreadyknowit'),
            'organisation' => 'CompanyThree',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);

        User::create([
            'name' => 'Ava Williams',
            'email' => 'tester5@adamriaz.com',
            'password' => Hash::make('youneverguessthisone'),
            'organisation' => 'CompanyThree',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
