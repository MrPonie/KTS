<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Response;
use App\Models\Test;
use App\Models\Test_User_Response;
use App\Models\User;

class TestUserResponseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TestUserResponse::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'test_id' => Test::factory(),
            'user_id' => User::factory(),
            'response_id' => Response::factory(),
        ];
    }
}
