<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = RestaurantUser::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'slug' => Str::slug($this->faker->name()),
      'name' => $this->faker->name(),
      'bio' => $this->faker->sentence(15),
      'designation' => $this->faker->text(255),
      'company' => $this->faker->text(255),
      'phone' => $this->faker->phoneNumber(),
      'address' => $this->faker->address(),
      'email' => $this->faker->email(),
      'email_verified_at' => $this->faker->dateTime(),
      'password' => $this->faker->password(),
      'is_verified' => $this->faker->boolean(),
      'code_id' => \App\Models\Code::factory(),
    ];
  }
}
