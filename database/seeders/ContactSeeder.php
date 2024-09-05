<?php

namespace Database\Seeders;

use App\Models\RestaurantUser;
use Illuminate\Database\Seeder;

class restaurant_usereeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    RestaurantUser::factory()
      ->count(5)
      ->create();
  }
}
