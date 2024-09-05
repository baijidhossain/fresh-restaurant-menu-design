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
    Schema::table('social_links', function (Blueprint $table) {
      // Add the column if it does not exist
      if (!Schema::hasColumn('social_links', 'restaurant_user_id')) {
        $table->unsignedBigInteger('restaurant_user_id')->nullable();
      }
      // Add the foreign key constraint
      $table
        ->foreign('restaurant_user_id')
        ->references('id')
        ->on('restaurant_users')
        ->onUpdate('CASCADE')
        ->onDelete('CASCADE');
    });
  }

  public function down(): void
  {
    Schema::table('social_links', function (Blueprint $table) {
      // Drop the foreign key constraint
      $table->dropForeign(['restaurant_user_id']);
      // Optionally, drop the column if you want to reverse the migration completely
      $table->dropColumn('restaurant_user_id');
    });
  }
};
