<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder {
    
    public function run() {
        User::create([
            'username' => 'superuser',
            'email' => 'superuser@gmail.com',
            'password' => Hash::make("Password123*"),
            'oib' => Str::random(11),
            'first_name' => Str::random(8),
            'last_name' => Str::random(8),
            'residence' => Str::random(20),
            'date_of_birth' => Carbon::today()->subDays(rand(0, 365)),
            'available_vacation_days' => 20,
            'is_superuser' => true
        ]);
    }
}
