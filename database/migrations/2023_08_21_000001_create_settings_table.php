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
    Schema::create('settings', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->time('start1')->nullable();
      $table->time('end1')->nullable();
      $table->time('start2')->nullable();
      $table->time('end2')->nullable();
      $table->time('start3')->nullable();
      $table->time('end3')->nullable();
      $table->string('BINANCE_API_KEY')->unique()->nullable();
      $table->string('BINANCE_API_SECRET')->unique()->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('settings');
  }
};
