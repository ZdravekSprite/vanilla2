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
    Schema::create('firms', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('address')->nullable();
      $table->string('oib')->nullable();
      $table->string('iban')->nullable();
      $table->string('bank')->nullable();
      //radni sati dan
      $table->string('t01')->nullable();
      //radni sati noć
      $table->string('t02')->nullable();
      //radni sati nedelja
      $table->string('t03')->nullable();
      //radni sati nedelja noć
      $table->string('t04')->nullable();
      //radni sati blagdan
      $table->string('t05')->nullable();
      //radni sati blagdan noć
      $table->string('t06')->nullable();
      //radni sati nedelja i blagdan
      $table->string('t07')->nullable();
      //radni sati nedelja i blagdan noć
      $table->string('t08')->nullable();
      //prekovremeni rad
      $table->string('t09')->nullable();
      //godišnji odmor
      $table->string('t10')->nullable();
      //bolovanje
      $table->string('t11')->nullable();
      //blagdani,izbori
      $table->string('t12')->nullable();
      //plaćeni dopust
      $table->string('t13')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('firms');
  }
};
