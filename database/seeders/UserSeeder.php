<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        User::query()->create([
            'name' => 'مهدی',
            'email' => 'guts2day@gmail.com',
            'is_superuser' => 1,
            'password' => '123123123',
        ]);
        User::query()->create([
            'name' => 'محمد',
            'email' => 'mahdi4al@gmail.com',
            'is_staff' => 1,
            'password' => '123123123',
        ]);
        for ($i = 0; $i < 10; $i++) {
            User::query()->create([
                'name' => fake()->name(),
                'email' => fake()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Str::random(10), // password
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
