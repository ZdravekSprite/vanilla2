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
      $table->tinyInteger('sindikat')->nullable();
      $table->mediumInteger('kredit')->nullable();
      $table->tinyInteger('first')->nullable();
      $table->tinyInteger('last')->nullable();
      //radni sati dan
      $table->tinyInteger('h01')->nullable();
      $table->mediumInteger('v01')->nullable();
      //radni sati noć
      $table->tinyInteger('h02')->nullable();
      $table->mediumInteger('v02')->nullable();
      //radni sati nedelja
      $table->tinyInteger('h03')->nullable();
      $table->mediumInteger('v03')->nullable();
      //radni sati nedelja noć
      $table->tinyInteger('h04')->nullable();
      $table->mediumInteger('v04')->nullable();
      //radni sati blagdan
      $table->tinyInteger('h05')->nullable();
      $table->mediumInteger('v05')->nullable();
      //radni sati blagdan noć
      $table->tinyInteger('h06')->nullable();
      $table->mediumInteger('v06')->nullable();
      //radni sati nedelja i blagdan
      $table->tinyInteger('h07')->nullable();
      $table->mediumInteger('v07')->nullable();
      //radni sati nedelja i blagdan noć
      $table->tinyInteger('h08')->nullable();
      $table->mediumInteger('v08')->nullable();
      //prekovremeni rad
      $table->tinyInteger('h09')->nullable();
      $table->mediumInteger('v09')->nullable();
      //godišnji odmor
      $table->tinyInteger('h10')->nullable();
      $table->mediumInteger('v10')->nullable();
      //bolovanje
      $table->tinyInteger('h11')->nullable();
      $table->mediumInteger('v11')->nullable();
      //blagdani,izbori
      $table->tinyInteger('h12')->nullable();
      $table->mediumInteger('v12')->nullable();
      //plaćeni dopust
      $table->tinyInteger('h13')->nullable();
      $table->mediumInteger('v13')->nullable();

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
