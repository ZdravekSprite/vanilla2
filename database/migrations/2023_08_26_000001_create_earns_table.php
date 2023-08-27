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
    Schema::create('earn_l_p_s', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->integer('positionId');
      $table->string('productId');
      $table->string('asset');
      $table->string('amount');
      $table->integer('purchaseTime');
      $table->integer('duration');
      $table->integer('accrualDays');
      $table->string('rewardAsset');
      $table->string('rewardAmt');
      $table->string('nextPay');
      $table->integer('nextPayDate');
      $table->integer('payPeriod');
      $table->string('redeemAmountEarly');
      $table->integer('rewardsEndDate');
      $table->integer('deliverDate');
      $table->integer('redeemPeriod');
      $table->boolean('canRedeemEarly');
      $table->boolean('autoSubscribe');
      $table->string('type');
      $table->string('status');
      $table->boolean('canReStake');
      $table->string('apy');
      $table->timestamps();
    });
    Schema::create('earn_l_l_s', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->string('projectId');
      $table->string('asset');
      $table->string('rewardAsset');
      $table->integer('duration');
      $table->boolean('renewable');
      $table->boolean('isSoldOut');
      $table->string('apr');
      $table->string('status');
      $table->integer('subscriptionStartTime');
      $table->string('totalPersonalQuota');
      $table->string('minimum');
      $table->timestamps();
    });
    Schema::create('earn_f_p_s', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->string('productId');
      $table->string('totalAmount');
      $table->string('tierAnnualPercentageRate');
      $table->string('latestAnnualPercentageRate');
      $table->string('asset');
      $table->boolean('canRedeem');
      $table->string('collateralAmount');
      $table->string('yesterdayRealTimeRewards');
      $table->string('cumulativeBonusRewards');
      $table->string('cumulativeRealTimeRewards');
      $table->string('cumulativeTotalRewards');
      $table->boolean('autoSubscribe');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('earn_l_p_s');
    Schema::dropIfExists('earn_l_l_s');
    Schema::dropIfExists('earn_f_p_s');
  }
};
