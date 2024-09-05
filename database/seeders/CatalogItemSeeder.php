<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogItemSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Example data
    $menuItems = [
      [
        'catalog_id' => 1,
        'name' => 'Beef Burger (Double Decker)',
        'image' => 'beef-burger-double-decker.png',
        'description' => 'Gourmet burger with a juicy beef patty, secret herbs, pickles, caramelized onions, sautéed mushrooms, tomato, mustard, cheddar, fries, and secret dip.',
        'price' => 12.99,
        'offer_price' => 10.99,
        'popular' => 1,
        'custom_field' => 'Available 10:30 am - 10:30 pm',
        'status' => 1,
        'display_order' => 1,
        'created_at' => now(),
        'updated_at' => now()
      ],

      [
        'catalog_id' => 1,
        'name' => 'Beef Burger Meal',
        'image' => 'beef-burger-meal.png',
        'description' => 'Indulge at our Best Restaurant with the Beef Burger Meal: juicy beef patty, secret herbs, pickles, onions, mushrooms, tomato, cheddar, fries, and dip.',
        'price' => 12.99,
        'offer_price' => 0,
        'popular' => 1,
        'custom_field' => 'Available 10:30 am - 10:30 pm',
        'status' => 1,
        'display_order' => 2,
        'created_at' => now(),
        'updated_at' => now()
      ],

      [
        'catalog_id' => 1,
        'name' => 'Beef Burger Only',
        'image' => 'beef-burger-only.png',
        'description' => 'Experience burger bliss with our Best Burger juicy beef patty, secret herbs, pickles, caramelized onions, mushrooms, and tomato in soft buns.',
        'price' => 12.99,
        'offer_price' => 0,
        'popular' => 1,
        'custom_field' => 'Available 10:30 am - 10:30 pm',
        'status' => 1,
        'display_order' => 3,
        'created_at' => now(),
        'updated_at' => now()
      ],

      [
        'catalog_id' => 1,
        'name' => 'Chicken Cheese',
        'image' => 'combo-chicken-cheese.png',
        'description' => 'Herfy’s crispy chicken patty, made with 100% chicken breast and no preservatives, topped with lettuce creamy mayo, and cheese on a toasted sesame bun.',
        'price' => 12.99,
        'offer_price' => 0,
        'popular' => 1,
        'custom_field' => 'Available 10:30 am - 10:30 pm',
        'status' => 1,
        'display_order' => 4,
        'created_at' => now(),
        'updated_at' => now()
      ],

      [
        'catalog_id' => 1,
        'name' => 'Big Herfy',
        'image' => 'combo-big-herfy.png',
        'description' => 'A juicy, 100% pure beef patty with no fillers, seasoned with secret herbs, lettuce, mayo, tomatoes, ketchup, and cheese on a sesame bun.',
        'price' => 12.99,
        'offer_price' => 0,
        'popular' => 1,
        'custom_field' => 'Available 10:30 am - 10:30 pm',
        'status' => 1,
        'display_order' => 5,
        'created_at' => now(),
        'updated_at' => now()
      ],

      [
        'catalog_id' => 1,
        'name' => 'Veggie Burger',
        'image' => 'combo-veggi-burger.png',
        'description' => 'A gently spiced mixed vegetable patty topped with creamy mayonnaise, shredded iceberg lettuce in a soft toasted seasame seed bun.',
        'price' => 12.99,
        'offer_price' => 0,
        'popular' => 1,
        'custom_field' => 'Available 10:30 am - 10:30 pm',
        'status' => 1,
        'display_order' => 6,
        'created_at' => now(),
        'updated_at' => now()
      ],


      // Pizza
      [
        'catalog_id' => 2,
        'name' => 'Pizza Tuna Olive',
        'image' => 'pizza-tuna-olive.jpg',
        'description' => 'Thin crust flatbread with tuna, red chilli flex, black olives and fresh mozzarella cheese makes it one delightful meal.',
        'price' => 500,
        'offer_price' => 0,
        'popular' => 0,
        'custom_field' => 'Available 10:30 am - 10:30 pm',
        'status' => 1,
        'display_order' => 7,
        'created_at' => now(),
        'updated_at' => now()
      ],

      // Add more items as needed
    ];


    DB::table('catalog_items')->insert($menuItems);

    // Insert data into menu_items table

  }
}
