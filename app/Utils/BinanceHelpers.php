<?php

namespace App\Utils;

use App\Models\Coin;
use App\Models\EarnFL;
use App\Models\EarnFP;
use App\Models\EarnLL;
use App\Models\EarnLP;
use App\Models\Settings;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BinanceHelpers
{
  public function getBinanceData()
  {
    //return (new BinanceHelpers)->getCapitalConfigGetall();
    return true;
  }

  public function getCapitalConfigGetall()
  {
    $settings = Settings::where('user_id', Auth::user()->id)->first();
    if (!$settings) {
      $user = Auth::user();
      $settings = new Settings();
      $settings->user_id = $user->id;
      $settings->api_key = '';
      $settings->api_secret = '';
      $settings->save();
      return null;
    }
    if ($settings->BINANCE_API_KEY == '' || $settings->BINANCE_API_SECRET == '') return null;

    $coins_count = Coin::all()->count();
    if ($coins_count > 0) {
      $coins_last_update = Coin::orderBy('updated_at', 'DESC')->first()->updated_at;
      $diff = $coins_last_update->diff(new DateTime());
    }
    //dd($coins_last_update,$diff);
    if (!$coins_count  || ($diff && $diff->d > 1)) {
      $capitalConfigGetall = (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/capital/config/getall');
      //dd($capitalConfigGetall);
      foreach ($capitalConfigGetall as $key => $value) {
        $coin = Coin::whereCoin($value->coin)->first();
        if (!$coin) $coin = new Coin();
        $coin->coin = $value->coin;
        $coin->depositAllEnable = $value->depositAllEnable;
        $coin->withdrawAllEnable = $value->withdrawAllEnable;
        $coin->name = $value->name;
        $coin->free = $value->free;
        $coin->locked = $value->locked;
        $coin->freeze = $value->freeze;
        $coin->withdrawing = $value->withdrawing;
        $coin->ipoing = $value->ipoing;
        $coin->ipoable = $value->ipoable;
        $coin->storage = $value->storage;
        $coin->isLegalMoney = $value->isLegalMoney;
        $coin->trading = $value->trading;
        $coin->save();
      };
    }
    $coins = Coin::all()->count();
    return $coins;
  }

  public function getSimpleEarnLockedPosition()
  {
    $settings = Settings::where('user_id', Auth::user()->id)->first();
    if (!$settings) {
      $user = Auth::user();
      $settings = new Settings();
      $settings->user_id = $user->id;
      $settings->api_key = '';
      $settings->api_secret = '';
      $settings->save();
      return null;
    }
    if ($settings->BINANCE_API_KEY == '' || $settings->BINANCE_API_SECRET == '') return null;

    $earns_count = EarnLP::all()->count();
    if ($earns_count > 0) {
      $earns_last_update = EarnLP::orderBy('updated_at', 'DESC')->first()->updated_at;
      $diff = $earns_last_update->diff(new DateTime());
    }
    if (!$earns_count  || ($diff && $diff->d > 1)) {
      $simpleEarnLockedPosition = (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/simple-earn/locked/position');
      //dd($simpleEarnLockedPosition);
      foreach ($simpleEarnLockedPosition->rows as $key => $value) {
        $earn = EarnLP::where('positionId', $value->positionId)->first();
        if (!$earn) $earn = new EarnLP();
        $earn->positionId = $value->positionId;
        $earn->user_id = Auth::user()->id;
        $earn->productId = $value->productId;
        $earn->asset = $value->asset;
        $earn->amount = $value->amount;
        $earn->purchaseTime = $value->purchaseTime;
        $earn->duration = $value->duration;
        $earn->accrualDays = $value->accrualDays;
        $earn->rewardAsset = $value->rewardAsset;
        $earn->rewardAmt = $value->rewardAmt;
        $earn->nextPay = $value->nextPay;
        $earn->nextPayDate = $value->nextPayDate;
        $earn->payPeriod = $value->payPeriod;
        $earn->redeemAmountEarly = $value->redeemAmountEarly;
        $earn->rewardsEndDate = $value->rewardsEndDate;
        $earn->deliverDate = $value->deliverDate;
        $earn->redeemPeriod = $value->redeemPeriod;
        $earn->canRedeemEarly = $value->canRedeemEarly;
        $earn->autoSubscribe = $value->autoSubscribe;
        $earn->type = $value->type;
        $earn->status = $value->status;
        $earn->canReStake = $value->canReStake;
        $earn->apy = $value->apy;
        $earn->save();
      }
    }
    $earns = EarnLP::all()->count();
    return $earns;
  }

  public function getSimpleEarnLockedList()
  {
    $settings = Settings::where('user_id', Auth::user()->id)->first();
    if (!$settings) {
      $user = Auth::user();
      $settings = new Settings();
      $settings->user_id = $user->id;
      $settings->api_key = '';
      $settings->api_secret = '';
      $settings->save();
      return null;
    }
    if ($settings->BINANCE_API_KEY == '' || $settings->BINANCE_API_SECRET == '') return null;

    $earns_count = EarnLL::all()->count();
    if ($earns_count > 0) {
      $earns_last_update = EarnLL::orderBy('updated_at', 'DESC')->first()->updated_at;
      $diff = $earns_last_update->diff(new DateTime());
    }
    if (!$earns_count  || ($diff && $diff->d > -1)) {
      $simpleEarnLockedList = (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/simple-earn/locked/list', ['current' => 3, 'size' => 100]);
      //dd($simpleEarnLockedList);
      foreach ($simpleEarnLockedList->rows as $key => $value) {
        $earn = EarnLL::where('projectId', $value->projectId)->first();
        if (!$earn) $earn = new EarnLL();
        $earn->projectId = $value->projectId;
        $earn->user_id = Auth::user()->id;
        $earn->asset = $value->detail->asset;
        $earn->rewardAsset = $value->detail->rewardAsset ?? '';
        $earn->duration = $value->detail->duration;
        $earn->renewable = $value->detail->renewable;
        $earn->isSoldOut = $value->detail->isSoldOut;
        $earn->apr = $value->detail->apr ?? '';
        $earn->status = $value->detail->status;
        $earn->subscriptionStartTime = $value->detail->subscriptionStartTime;
        $earn->totalPersonalQuota = $value->quota->totalPersonalQuota;
        $earn->minimum = $value->quota->minimum;
        $earn->save();
      }
    }
    $earns = EarnLL::all()->count();
    return $earns;
  }

  public function getSimpleEarnFlexiblePosition()
  {
    $settings = Settings::where('user_id', Auth::user()->id)->first();
    if (!$settings) {
      $user = Auth::user();
      $settings = new Settings();
      $settings->user_id = $user->id;
      $settings->api_key = '';
      $settings->api_secret = '';
      $settings->save();
      return null;
    }
    if ($settings->BINANCE_API_KEY == '' || $settings->BINANCE_API_SECRET == '') return null;

    $earns_count = EarnFP::all()->count();
    if ($earns_count > 0) {
      $earns_last_update = EarnFP::orderBy('updated_at', 'DESC')->first()->updated_at;
      $diff = $earns_last_update->diff(new DateTime());
    }
    if (!$earns_count  || ($diff && $diff->d > 1)) {
      $simpleEarnFlexiblePosition = (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/simple-earn/flexible/position');
      //dd($simpleEarnFlexiblePosition);
      foreach ($simpleEarnFlexiblePosition->rows as $key => $value) {
        $earn = EarnFP::where('productId', $value->productId)->first();
        if (!$earn) $earn = new EarnFP();
        $earn->productId = $value->productId;
        $earn->user_id = Auth::user()->id;
        $earn->totalAmount = $value->totalAmount;
        $earn->tierAnnualPercentageRate = isset($value->tierAnnualPercentageRate) ? json_encode($value->tierAnnualPercentageRate) : '';
        $earn->latestAnnualPercentageRate = $value->latestAnnualPercentageRate;
        $earn->asset = $value->asset;
        $earn->canRedeem = $value->canRedeem;
        $earn->collateralAmount = $value->collateralAmount;
        $earn->yesterdayRealTimeRewards = $value->yesterdayRealTimeRewards;
        $earn->cumulativeBonusRewards = $value->cumulativeBonusRewards;
        $earn->cumulativeRealTimeRewards = $value->cumulativeRealTimeRewards;
        $earn->cumulativeTotalRewards = $value->cumulativeTotalRewards;
        $earn->autoSubscribe = $value->autoSubscribe;
        $earn->save();
      }
    }
    $earns = EarnFP::all()->count();
    return $earns;
  }

  public function getSimpleEarnFlexibleList()
  {
    $settings = Settings::where('user_id', Auth::user()->id)->first();
    if (!$settings) {
      $user = Auth::user();
      $settings = new Settings();
      $settings->user_id = $user->id;
      $settings->api_key = '';
      $settings->api_secret = '';
      $settings->save();
      return null;
    }
    if ($settings->BINANCE_API_KEY == '' || $settings->BINANCE_API_SECRET == '') return null;

    $earns_count = EarnFL::all()->count();
    if ($earns_count > 0) {
      $earns_last_update = EarnFL::orderBy('updated_at', 'DESC')->first()->updated_at;
      $diff = $earns_last_update->diff(new DateTime());
    }
    if (!$earns_count  || ($diff && $diff->d > 1)) {
      $simpleEarnFlexibleList = (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/simple-earn/flexible/list', ['current' => 4, 'size' => 100]);
      //dd($simpleEarnFlexibleList);
      foreach ($simpleEarnFlexibleList->rows as $key => $value) {
        $earn = EarnFL::where('productId', $value->productId)->first();
        if (!$earn) $earn = new EarnFL();
        $earn->productId = $value->productId;
        $earn->user_id = Auth::user()->id;
        $earn->asset = $value->asset;
        $earn->latestAnnualPercentageRate = $value->latestAnnualPercentageRate;
        $earn->canPurchase = $value->canPurchase;
        $earn->canRedeem = $value->canRedeem;
        $earn->isSoldOut = $value->isSoldOut;
        $earn->hot = $value->hot;
        $earn->minPurchaseAmount = $value->minPurchaseAmount;
        $earn->subscriptionStartTime = $value->subscriptionStartTime;
        $earn->status = $value->status;
        $earn->save();
      }
    }
    $earns = EarnFL::all()->count();
    return $earns;
  }

  public function getHttp($url, $array = null)
  {
    $user = Auth::user();
    $settings = Settings::whereUserId($user->id)->first();
    if (!$settings) {
      $settings = new Settings();
      $settings->user_id = $user->id;
      $settings->BINANCE_API_KEY = '';
      $settings->BINANCE_API_SECRET = '';
      $settings->save();
    }
    if ($settings->BINANCE_API_KEY == '' && $settings->BINANCE_API_SECRET == '') return '';

    $apiKey = $settings->BINANCE_API_KEY;
    $apiSecret = $settings->BINANCE_API_SECRET;
    $time = json_decode(Http::get('https://api.binance.com/api/v3/time'));
    $serverTime = $time->serverTime;
    $timestampArray = array(
      "timestamp" => $serverTime
    );
    $queryArray = $array ? $array + $timestampArray : $timestampArray;
    $signature = hash_hmac('SHA256', http_build_query($queryArray), $apiSecret);
    $signatureArray = array("signature" => $signature);
    $getArray = $queryArray + $signatureArray;
    $json = json_decode(Http::withHeaders([
      'X-MBX-APIKEY' => $apiKey
    ])->get($url, $getArray));

    return $json;
  }

  public function get($url)
  {
    $http_get = json_decode(Http::get($url));
    return $http_get;
  }
}
