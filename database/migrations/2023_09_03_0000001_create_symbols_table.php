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
    Schema::create('symbols', function (Blueprint $table) {
      $table->id();
      $table->string('symbol');
      $table->string('status');
      $table->foreignId('baseAsset_id')->constrained(
        table: 'coins',
        indexName: 'id'
      )->onUpdate('cascade')->onDelete('cascade');
      $table->tinyInteger('baseAssetPrecision');
      $table->foreignId('quoteAsset_id')->constrained(
        table: 'coins',
        indexName: 'id'
      )->onUpdate('cascade')->onDelete('cascade');
      $table->tinyInteger('quotePrecision');
      $table->tinyInteger('baseCommissionPrecision');
      $table->tinyInteger('quoteCommissionPrecision');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('symbols');
  }
};
