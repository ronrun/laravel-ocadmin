<?php

namespace Database\Factories\Catalog;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User\User>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $randDigit = rand(5,15);
        $slug = $this->faker->text();
        $slug = trim(substr($slug, 0, $randDigit));
        $slug = str_replace(' ', '-', $slug);
        $model = $this->faker->text();
        $model = trim(substr($model, 0, $randDigit));
        $model = str_replace(' ', '-', $model);

        return [
            'slug' => $slug,
            'model' => $model,
            'price' => rand(50,300),
            'quantity' => rand(1,500),
            'is_active' => 1,
        ];
    }
}
