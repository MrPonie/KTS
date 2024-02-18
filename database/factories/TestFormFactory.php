<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Test_Form;
use App\Models\User;

class TestFormFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TestForm::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'created_by' => User::factory(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'questions_json' => '{}',
            'question_count' => $this->faker->randomNumber(),
            'max_points' => $this->faker->randomFloat(2, 0, 999999.99),
        ];
    }
}
