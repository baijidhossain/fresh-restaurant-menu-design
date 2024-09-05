<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('restaurants')->insert([
      [
        'restaurant_user_id' => 1, // Ensure this ID exists in restaurant_users
        'name' => 'Akboria Grand Chap Ghor & Restaurant',
        'phone' => '01775051601',
        'address' => 'Kaloni Bus stand, opposite side of Labaid Hospital, Bogura sadar, bogura.',
        'start_time' => '10:00:00',
        'end_time' => '22:00:00',
        'created_at' => now(),
      ],

      [
        'restaurant_user_id' => 2, // Ensure this ID exists in restaurant_users
        'name' => '7 Star Biryani House & restaurant',
        'phone' => '01775051602',
        'address' => 'koloni sherpur road bogura ,beside chunno chap ghar',
        'start_time' => '10:00:00',
        'end_time' => '22:00:00',
        'created_at' => now(),
      ],

    ]);
  }
}
