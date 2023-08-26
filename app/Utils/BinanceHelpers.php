<?php

namespace App\Utils;

use App\Models\Coin;
use App\Models\Earn;
use App\Models\Settings;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BinanceHelpers
{
  public function getBinanceData()
  {
    return (new BinanceHelpers)->getSimpleEarnLockedPosition();
    //$coins = (new BinanceHelpers)->getCapitalConfigGetall();
    //return $coins;
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

    $earns_count = Earn::where('earn','simpleEarnLockedPosition')->count();
    if ($earns_count > 0) {
      $earns_last_update = Earn::where('earn','simpleEarnLockedPosition')->orderBy('updated_at', 'DESC')->first()->updated_at;
      $diff = $earns_last_update->diff(new DateTime());
    }
    //dd($coins_last_update,$diff);
    if (!$earns_count  || ($diff && $diff->d > 1)) {
      $simpleEarnLockedPosition = (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/simple-earn/locked/position');
      //dd($simpleEarnLockedPosition);
      foreach ($simpleEarnLockedPosition->rows as $key => $value) {
        $earn = Earn::where('positionId', $value->positionId)->first();
        if (!$earn) $earn = new Earn();
        $earn->earn = 'simpleEarnLockedPosition';
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
    $earns = Earn::where('earn','simpleEarnLockedPosition')->count();
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
