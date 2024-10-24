<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content'    => $this->faker->sentence,
            'rating'     => $this->faker->numberBetween(1, 5),
            'product_id' => Product::factory(),
            'user_id'    => User::factory(),
        ];
    }
}
