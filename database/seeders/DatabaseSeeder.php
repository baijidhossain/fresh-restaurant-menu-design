<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // Adding an admin user
    $user = \App\Models\User::factory()
      ->count(1)
      ->create([
        'email' => 'admin@admin.com',
        'password' => Hash::make('admin'),
      ]);

    $this->call(PermissionsSeeder::class);
    $this->call(CodeSeeder::class);
    //$this->call(restaurant_usereeder::class);
    //$this->call(SocialLinkSeeder::class);
    //$this->call(UserSeeder::class);


    // Restaurant seeders
    $this->call(RestaurantUserSeeder::class);
    $this->call(RestaurantSeeder::class);
    $this->call(CatalogSeeder::class);
    $this->call(CatalogItemSeeder::class);
  }
}
