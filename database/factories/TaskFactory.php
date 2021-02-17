<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $now = now();
        return [
            'description' => $this->faker->sentence(3),
            'comment' => $this->faker->sentence(5),
            'user_id' => $this->faker->randomNumber(),
            'subcategory_id' => $this->faker->randomNumber(),
            'priority' => $this->faker->randomNumber(),
            'created_at' => $now,
            'updated_at' => $now
        ];
    }
}
