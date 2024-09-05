<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('restaurant_users', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('slug');
      $table->string('name');
      $table->text('bio')->nullable();
      $table->string('designation')->nullable();
      $table->string('company')->nullable();
      $table->string('phone')->nullable();
      $table->string('address')->nullable();
      $table->string('email');
      $table->timestamp('email_verified_at')->nullable();
      $table->string('photo')->nullable();
      $table->string('password');
      $table->boolean('is_verified');
      $table->unsignedBigInteger('code_id');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('restaurant_user');
  }
};
