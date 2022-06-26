<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CrawlLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text,
            'input_url' => $this->faker->url,
            'url' => $this->faker->url,
            'description' => $this->faker->paragraph,
            'screenshot' => $this->faker->imageUrl,
            'raw_body' => $this->faker->paragraph,
            'parsed_body' => $this->faker->paragraph,
        ];
    }
}
