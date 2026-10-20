<?php

namespace Database\Factories;

use App\Models\Endereço;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Endereço>
 */
class EndereçoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'endereço' => fake()->address()
        ];
    }
}
