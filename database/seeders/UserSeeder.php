<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Vendor',
            'email' => 'vendor@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
            'role' => 'vendor',
            'opening_hours' => [
                ['title' => 'Sunday', 'open' => '08:00', 'close' => '17:00', 'enabled' => true],
                ['title' => 'Monday', 'open' => '08:00', 'close' => '17:00', 'enabled' => true],
                ['title' => 'Tuesday', 'open' => '08:00', 'close' => '17:00', 'enabled' => true],
                ['title' => 'Wednesday', 'open' => '08:00', 'close' => '17:00', 'enabled' => true],
                ['title' => 'Thursday', 'open' => '08:00', 'close' => '17:00', 'enabled' => true],
                ['title' => 'Friday', 'open' => '08:00', 'close' => '17:00', 'enabled' => false],
                ['title' => 'Saturday', 'open' => '08:00', 'close' => '17:00', 'enabled' => false],
            ]
        ]);
    }
}
