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
    Schema::create('catalog_items', function (Blueprint $table) {

      $table->id('id');
      $table->unsignedBigInteger('catalog_id');
      $table->string('name', 100);
      $table->string('image', 150)->nullable();
      $table->string('description', 150)->nullable();
      $table->decimal('price', 10, 2);
      $table->decimal('offer_price', 10, 2)->nullable();
      $table->tinyInteger('popular')->default("0");
      $table->string('custom_field', 100)->nullable();
      $table->tinyInteger('status')->default("1");
      $table->tinyInteger('display_order')->default("0");
      $table->timestamps();
      // Foreign key constraint
      $table->foreign('catalog_id')->references('id')->on('catalogs')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('menu_items');
  }
};
