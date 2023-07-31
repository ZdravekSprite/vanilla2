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
    Schema::create('euros', function (Blueprint $table) {
      $table->id();
      $table->date('time')->unique();
      $table->tinyInteger('no1');
      $table->tinyInteger('no2');
      $table->tinyInteger('no3');
      $table->tinyInteger('no4');
      $table->tinyInteger('no5');
      $table->tinyInteger('bn1');
      $table->tinyInteger('bn2');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('euros');
  }
};
