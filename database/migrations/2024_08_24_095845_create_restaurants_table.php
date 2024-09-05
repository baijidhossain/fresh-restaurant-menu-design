<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('restaurants', function (Blueprint $table) {
      $table->id('id');
      $table->unsignedBigInteger('restaurant_user_id');
      $table->string('name', 40);
      $table->string('logo', 100)->nullable();
      $table->string('banner', 100)->nullable();
      $table->string('phone', 20)->nullable();
      $table->string('address', 150)->nullable();
      $table->time('start_time')->nullable();
      $table->time('end_time')->nullable();
      $table->timestamps();
      $table->foreign('restaurant_user_id')
        ->references('id')
        ->on('restaurant_users')
        ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('restaurants');
  }
};
