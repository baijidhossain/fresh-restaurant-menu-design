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
    Schema::create('visits', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('ip_address', 45)->nullable();
      $table->string('user_agent')->nullable();
      $table->string('device_type')->nullable();
      $table->string('browser')->nullable();
      $table->string('os')->nullable();
      $table->unsignedBigInteger('restaurant_user_id');
      $table->foreign('restaurant_user_id')->references('id')->on('restaurant_users')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('visits');
  }
};
