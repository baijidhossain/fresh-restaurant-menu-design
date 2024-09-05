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
    Schema::table('restaurant_users', function (Blueprint $table) {
      $table
        ->foreign('code_id')
        ->references('id')
        ->on('codes')
        ->onUpdate('CASCADE')
        ->onDelete('CASCADE');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('restaurant_users', function (Blueprint $table) {
      $table->dropForeign(['code_id']);
    });
  }
};
