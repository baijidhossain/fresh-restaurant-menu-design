<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RestaurantUserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('restaurant_users')->insert([
      [
        'slug' => 'akboria-kacchi-khacchi',
        'name' => 'user',
        'bio' => 'Experienced chef with a passion for fine dining.',
        'designation' => 'Head Chef',
        'company' => 'Akboria Kacchi Khacchi',
        'phone' => '01775051601',
        'address' => 'Kazi Nazrul Islam Road, Near Akboria Grand Hotel, Bogura Sadar, Bogura, Bangladesh',
        'email' => 'user@gmail.com',
        'email_verified_at' => now(),
        'photo' => 'restaurant/users/user_placeholder.jpg',
        'password' => Hash::make('123456789'),
        'is_verified' => true,
        'code_id' => 1,
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'slug' => 'the-Pizza-dine-bogura',
        'name' => 'user2',
        'bio' => 'Specializes in authentic Bangladeshi biryani.',
        'designation' => 'Biryani Specialist',
        'company' => 'The Pizza Dine - Bogura',
        'phone' => '01775051602',
        'address' => 'Holding: 630, Rezaul Baki Road, Jalesharitola, Bogura',
        'email' => 'user2@gmail.com',
        'email_verified_at' => now(),
        'photo' => 'restaurant/users/user_placeholder.jpg',
        'password' => Hash::make('123456789'),
        'is_verified' => true,
        'code_id' => 2,
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'slug' => 'dab-chicken',
        'name' => 'user3',
        'bio' => 'Expert in Western cuisine with a focus on steak dishes.',
        'designation' => 'Steak Chef',
        'company' => 'Alpha Restaurant',
        'phone' => '01775051603',
        'address' => 'House:270, (Near Nur Mosjid) Ray Bahadur Road',
        'email' => 'user3@gmail.com',
        'email_verified_at' => now(),
        'photo' => 'restaurant/users/user_placeholder.jpg',
        'password' => Hash::make('123456789'),
        'is_verified' => true,
        'code_id' => 3,
        'created_at' => now(),
        'updated_at' => now(),
      ]

    ]);
  }
}
