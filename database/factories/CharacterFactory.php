<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Character>
 */
class CharacterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
		return [
			'project_id' => Project::inRandomOrder()->first()->id,
			'name' => fake()->firstName(),
			'description' => fake()->text(500),
			// 'appearance'  => fake()->text(500),
			// 'personality' => fake()->text(500),
			// 'motivations' => fake()->text(500),
			// 'flaws'       => fake()->text(500)
		];
    }
}