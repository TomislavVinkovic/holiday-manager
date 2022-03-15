<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    private function randomDigits($length) : string{
        $digits = '';
        $numbers = range(0,9);
        shuffle($numbers);
        for($i = 0; $i < $length; $i++){
            $digits .= $numbers[rand(0,8)];
        }
        return $digits;
    }

    public function definition()
    {
        return [
            'username' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make("Password123*"),
            'oib' => $this->randomDigits(11),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'residence' => $this->faker->city(),
            'date_of_birth' => $this->faker->date(),
            'available_vacation_days' => 20,
            'is_superuser' => false,
            'remember_token' => Str::random(10),
        ];
    }
}
