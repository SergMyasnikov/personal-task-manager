<?php

namespace Database\Factories;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubcategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subcategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $now = now();
        return [
            'name' => $this->faker->sentence(3),
            'user_id' => $this->faker->randomNumber(),
            'category_id' => $this->faker->randomNumber(),
            'is_default' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ];
    }
}
