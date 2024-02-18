<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            // 'created_by' => User::factory(),
            'username' => $this->faker->userName(),
            'password' => Hash::make('password'),
            'last_login_at' => $this->faker->dateTime(),
            'is_online' => $this->faker->boolean(),
        ];
    }
}
