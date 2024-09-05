<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {

    DB::table('catalogs')->insert([

      [
        'restaurant_id' => 1, // Make sure this ID exists in the restaurants table
        'name' => 'Burger',
        'status' => 1, // Active
        'display_order' => 1,
        'created_at' => now(),
        'updated_at' => now(),
      ],

      [
        'restaurant_id' => 1, // Make sure this ID exists in the restaurants table
        'name' => 'Pizza',
        'status' => 1, // Active
        'display_order' => 2,
        'created_at' => now(),
        'updated_at' => now(),
      ],

      [
        'restaurant_id' => 1, // Make sure this ID exists in the restaurants table
        'name' => 'Sandwich',
        'status' => 1, // Active
        'display_order' => 3,
        'created_at' => now(),
        'updated_at' => now(),
      ],

      [
        'restaurant_id' => 1, // Make sure this ID exists in the restaurants table
        'name' => 'Fried chicken',
        'status' => 1, // Active
        'display_order' => 4,
        'created_at' => now(),
        'updated_at' => now(),
      ],

      [
        'restaurant_id' => 1, // Make sure this ID exists in the restaurants table
        'name' => 'Soup',
        'status' => 1, // Active
        'display_order' => 5,
        'created_at' => now(),
        'updated_at' => now(),
      ],

      [
        'restaurant_id' => 1, // Make sure this ID exists in the restaurants table
        'name' => 'Vegetable',
        'status' => 1, // Active
        'display_order' => 6,
        'created_at' => now(),
        'updated_at' => now(),
      ],

      [
        'restaurant_id' => 1, // Make sure this ID exists in the restaurants table
        'name' => 'Mutton',
        'status' => 1, // Active
        'display_order' => 7,
        'created_at' => now(),
        'updated_at' => now(),
      ],

      [
        'restaurant_id' => 1, // Make sure this ID exists in the restaurants table
        'name' => 'Beef',
        'status' => 1, // Active
        'display_order' => 8,
        'created_at' => now(),
        'updated_at' => now(),
      ],

      [
        'restaurant_id' => 1, // Make sure this ID exists in the restaurants table
        'name' => 'Kebab',
        'status' => 1, // Active
        'display_order' => 9,
        'created_at' => now(),
        'updated_at' => now(),
      ],

      [
        'restaurant_id' => 1, // Make sure this ID exists in the restaurants table
        'name' => 'Desserts',
        'status' => 1, // Active
        'display_order' => 10,
        'created_at' => now(),
        'updated_at' => now(),
      ],

      [
        'restaurant_id' => 1, // Make sure this ID exists in the restaurants table
        'name' => 'Chicken',
        'status' => 1, // Active
        'display_order' => 11,
        'created_at' => now(),
        'updated_at' => now(),
      ],

      [
        'restaurant_id' => 1, // Make sure this ID exists in the restaurants table
        'name' => 'Chinese',
        'status' => 1, // Active
        'display_order' => 12,
        'created_at' => now(),
        'updated_at' => now(),
      ],

    ]);
  }
}
