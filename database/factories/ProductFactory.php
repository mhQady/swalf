<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Country;
use App\Models\Interest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $country = Country::find('191');
        $city = $country?->cities()->inRandomOrder()->first(['cities.id']);

        return [
            'name' => fake()->name(),
            'price' => fake()->randomFloat(2, 0, 100),
            'old_price' => fake()->randomFloat(2, 0, 100),
            'is_published' => fake()->boolean(),
            'description' => fake()->text(),
            'user_id' => User::inRandomOrder()->first('id')?->id,
            'interest_id' => Interest::inRandomOrder()->first('id')?->id,
            'country_id' => '191',
            'city_id' => $city?->id,
        ];
    }
}
