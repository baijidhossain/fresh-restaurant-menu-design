<?php

namespace Database\Factories;

use App\Models\Code;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Code::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->url(),
            'has_card' => $this->faker->boolean(),
        ];
    }
}
