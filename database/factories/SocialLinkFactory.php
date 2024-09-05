<?php

namespace Database\Factories;

use App\Models\SocialLink;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocialLinkFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = SocialLink::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'key' => $this->faker->text(255),
      'value' => $this->faker->text(255),
      'contact_id' => \App\Models\RestaurantUser::factory(),
    ];
  }
}
