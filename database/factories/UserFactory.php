<?php

namespace Database\Factories;

use App\Enums\User\GenderEnum;
use Illuminate\Support\Str;
use App\Enums\User\CompleteDataEnum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'complete_data' => CompleteDataEnum::INTERESTS_ENTERED,
            'phone_code' => '966',
            'phone' => fake()->unique()->phoneNumber(),
            'phone_verified_at' => now(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'gender' => GenderEnum::random()->value,
            'birth_date' => fake()->date(),
            'country_id' => 191,
            'about' => fake()->text(),
            'password' => 'password',
        ];
    }

}
