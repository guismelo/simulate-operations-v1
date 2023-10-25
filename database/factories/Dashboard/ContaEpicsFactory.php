<?php

namespace Database\Factories\Dashboard;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Dashboard\ContaEpics;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ContaEpicsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'Nome' => fake()->name(),
            'Email' => fake()->unique()->safeEmail(),
            'Celular' => now(),
            'DataCriacao' => date('Y-m-d H:i:s'),
            'TokenConta' => Str::random(10)
        ];
    }
}
