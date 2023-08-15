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
    Schema::create('months', function (Blueprint $table) {
      $table->id();
      $table->smallInteger('month');
      $table->foreignId('user_id')->constrained();
      $table->foreignId('firm_id')->constrained();
      $table->mediumInteger('bruto')->nullable();
      $table->tinyInteger('minuli')->nullable();
      $table->mediumInteger('odbitak')->nullable();
      $table->smallInteger('prirez')->nullable();
      $table->mediumInteger('prijevoz')->nullable();
      $table->mediumInteger('prehrana')->nullable();
      $table->tinyInteger('prekovremeni')->nullable();
      $table->smallInteger('stari')->nullable();
      $table->tinyInteger('nocni')->nullable();
      $table->mediumInteger('bolovanje')->nullable();
      $table->mediumInteger('stimulacija')->nullable();
      $table->mediumInteger('nagrada')->nullable();
      $table->mediumInteger('regres')->nullable();
      $table->mediumInteger('bozicnica')->nullable();
      $table->mediumInteger('prigodna')->nullable();
      $table->boolean('sindikat')->nullable();
      $table->mediumInteger('kredit')->nullable();
      $table->timestamps();
      $table->unique(['user_id', 'firm_id', 'month']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('months');
  }
};
