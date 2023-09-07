<?php

namespace App\Utils;

use App\Models\Coin;
use App\Models\EarnFL;
use App\Models\EarnFP;
use App\Models\EarnLL;
use App\Models\EarnLP;
use App\Models\Settings;
use App\Models\Symbol;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BinanceHelpers
{
  public function getBinanceData()
  {
    $settings = (new BinanceHelpers)->getSettings();
    if ($settings->BINANCE_API_KEY == '' || $settings->BINANCE_API_SECRET == '') return null;

    $getL = (new BinanceHelpers)->getSimpleEarnLockedPosition()->map(fn ($asset) => [
      'asset_id' => $asset->asset_id,
      'amount' => $asset->amount,
    ]);
    $getF = (new BinanceHelpers)->getSimpleEarnFlexiblePosition()->map(fn ($asset) => [
      'asset_id' => $asset->asset_id,
      'amount' => $asset->totalAmount,
    ]);
    $lendingAccount = (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/lending/union/account');
    $positionAmountVos = $lendingAccount->positionAmountVos;
    $allCoins = (new BinanceHelpers)->getCapitalConfigGetall();
    $BUSD = (new BinanceHelpers)->get('https://api.binance.com/api/v3/ticker/price?symbol=EURBUSD')->price;
    $filtered = $allCoins->map(function ($coin) use ($positionAmountVos, $getL, $getF) {
      $lending = collect($positionAmountVos)->filter(function ($value, $key) use ($coin) {
        return $value->asset == $coin->coin;
      })->reduce(function ($sum, $value) {
        return $sum * 1 + $value->amount;
      }) ?? 0;
      $earnL = collect($getL)->filter(function ($value, $key) use ($coin) {
        return $value['asset_id'] == $coin->id;
      })->reduce(function ($sum, $value) {
        return $sum * 1 + $value['amount'];
      }) ?? 0;
      $earnF = collect($getF)->filter(function ($value, $key) use ($coin) {
        return $value['asset_id'] == $coin->id;
      })->reduce(function ($sum, $value) {
        return $sum * 1 + $value['amount'];
      }) ?? 0;
      $all = $earnL + $lending + $coin->free + $coin->locked + $coin->freeze + $coin->withdrawing + $coin->ipoing + $coin->ipoable + $coin->storage;
      return [
        'coin' => $coin->coin,
        'depositAllEnable' => $coin->depositAllEnable,
        'withdrawAllEnable' => $coin->withdrawAllEnable,
        'name' => $coin->name,
        'free' => $coin->free * 1,
        'locked' => $coin->locked * 1,
        'freeze' => $coin->freeze * 1,
        'withdrawing' => $coin->withdrawing * 1,
        'ipoing' => $coin->ipoing * 1,
        'ipoable' => $coin->ipoable * 1,
        'storage' => $coin->storage * 1,
        'lending' => $lending,
        'earnL' => $earnL,
        'earnF' => $earnF,
        'all' => $all,
        'isLegalMoney' => $coin->isLegalMoney,
        'trading' => $coin->trading,
      ];
    })->filter(function ($value, $key) {
      return $value['all'] > 0;
    })->map(function ($coin) use ($BUSD) {
      $price = 0;
      if ($coin['coin'] == 'EUR') $price = 1;
      if (!$price) {
        $params = '?symbol=' . $coin['coin'] . 'EUR';
        $ticker = (new BinanceHelpers)->get('https://api.binance.com/api/v3/ticker/price' . $params);
        $price = isset($ticker->price) ? $ticker->price * 1 : 0;
      }
      if (!$price) {
        $params = '?symbol=EUR' . $coin['coin'];
        $ticker = (new BinanceHelpers)->get('https://api.binance.com/api/v3/ticker/price' . $params);
        $price = isset($ticker->price) ? 1 / $ticker->price : 0;
      }
      if (!$price) {
        $params = '?symbol=' . $coin['coin'] . 'BUSD';
        $ticker = (new BinanceHelpers)->get('https://api.binance.com/api/v3/ticker/price' . $params);
        $price = isset($ticker->price) ? $ticker->price / $BUSD : 0;
      }
      if (!$price) {
        $params = '?symbol=BUSD' . $coin['coin'];
        $ticker = (new BinanceHelpers)->get('https://api.binance.com/api/v3/ticker/price' . $params);
        $price = isset($ticker->price) ? $BUSD / $ticker->price : 0;
      }
      return  [
        ...$coin,
        'price' => $price,
      ];
    });
    return $filtered;
  }

  public function getCapitalConfigGetall($force = false)
  {
    if ((new BinanceHelpers)->toUpdate(Coin::all(), $force, 11, 12)) {
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
    $coins = Coin::all();
    return $coins;
  }

  public function getSimpleEarnLockedPosition($force = false)
  {
    if ((new BinanceHelpers)->toUpdate(EarnLP::all(), $force, 9, 10)) {
      $simpleEarnLockedPosition = (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/simple-earn/locked/position');
      //dd($simpleEarnLockedPosition);
      foreach ($simpleEarnLockedPosition->rows as $key => $value) {
        $earn = EarnLP::where('positionId', $value->positionId)->first();
        if (!$earn) $earn = new EarnLP();
        $earn->positionId = $value->positionId;
        $earn->user_id = Auth::user()->id;
        $earn->productId = $value->productId;
        $earn->asset_id = (new BinanceHelpers)->getCoin($value->asset)->id;
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
    $earns = EarnLP::all();
    return $earns;
  }

  public function getSimpleEarnLockedList($force = false)
  {
    if ((new BinanceHelpers)->toUpdate(EarnLL::all(), $force, 7, 8)) {
      $simpleEarnLockedList = (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/simple-earn/locked/list', ['current' => 3, 'size' => 100]);
      //dd($simpleEarnLockedList);
      foreach ($simpleEarnLockedList->rows as $key => $value) {
        $earn = EarnLL::where('projectId', $value->projectId)->first();
        if (!$earn) $earn = new EarnLL();
        $earn->projectId = $value->projectId;
        $earn->user_id = Auth::user()->id;
        $earn->asset_id = (new BinanceHelpers)->getCoin($value->detail->asset)->id;
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
    $earns = EarnLL::all();
    return $earns;
  }

  public function getSimpleEarnFlexiblePosition($force = false)
  {
    if ((new BinanceHelpers)->toUpdate(EarnFP::all(), $force, 5, 6)) {
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
        $earn->asset_id = (new BinanceHelpers)->getCoin($value->asset)->id;
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
    $earns = EarnFP::all();
    return $earns;
  }

  public function getSimpleEarnFlexibleList($force = false)
  {
    if ((new BinanceHelpers)->toUpdate(EarnFL::all(), $force, 3, 4)) {
      $simpleEarnFlexibleList = (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/simple-earn/flexible/list', ['current' => 4, 'size' => 100]);
      //dd($simpleEarnFlexibleList);
      foreach ($simpleEarnFlexibleList->rows as $key => $value) {
        $earn = EarnFL::where('productId', $value->productId)->first();
        if (!$earn) $earn = new EarnFL();
        $earn->productId = $value->productId;
        $earn->user_id = Auth::user()->id;
        $earn->asset_id = (new BinanceHelpers)->getCoin($value->asset)->id;
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
    $earns = EarnFL::all();
    return $earns;
  }

  public function exchangeInfo($force = false)
  {
    set_time_limit(0);

    if ((new BinanceHelpers)->toUpdate(Symbol::all(), $force, 1, 2)) {
      $exchangeInfo = (new BinanceHelpers)->get('https://api.binance.com/api/v3/exchangeInfo');
      //dd($exchangeInfo->symbols);
      foreach ($exchangeInfo->symbols as $key => $value) {
        $symbol = Symbol::where('symbol', $value->symbol)->first();
        if (!$symbol) $symbol = new Symbol();
        $symbol->symbol = $value->symbol; //string
        $symbol->status = $value->status; //string
        $baseAsset = (new BinanceHelpers)->getCoin($value->baseAsset);
        if (!$baseAsset) continue;
        $symbol->baseAsset_id = $baseAsset->id;
        $symbol->baseAssetPrecision = $value->baseAssetPrecision; //8
        $quoteAsset = (new BinanceHelpers)->getCoin($value->quoteAsset);
        if (!$quoteAsset) continue;
        $symbol->quoteAsset_id = $quoteAsset->id;
        $symbol->quotePrecision = $value->quotePrecision; //8
        $symbol->baseCommissionPrecision = $value->baseCommissionPrecision; //8
        $symbol->quoteCommissionPrecision = $value->quoteCommissionPrecision; //8
        $symbol->save();
      }
    }
    $symbols = Symbol::all();
    return $symbols;
  }

  public function getSettings()
  {
    $settings = Settings::where('user_id', Auth::user()->id)->first();
    if (!$settings) {
      $settings = new Settings();
      $settings->user_id = Auth::user()->id;
      $settings->BINANCE_API_KEY = '';
      $settings->BINANCE_API_SECRET = '';
      $settings->save();
    }
    return $settings;
  }

  public function getCoin($asset)
  {
    $coin = Coin::whereCoin($asset)->first();
    if (!$coin) (new BinanceHelpers)->getCapitalConfigGetall(true);
    $coin = Coin::whereCoin($asset)->first();
    return $coin;
  }

  public function toUpdate($models, $force = false, $from = 0, $to = 24)
  {
    $settings = (new BinanceHelpers)->getSettings();
    if ($settings->BINANCE_API_KEY == '' || $settings->BINANCE_API_SECRET == '') return false;

    //dd($models);
    $count = $models->count();
    if ($count == 0) return true;

    if ($force) return true;

    $now = new DateTime();
    $last_update = $models->sortByDesc('updated_at')->first()->updated_at;
    $diff = $last_update->diff($now);
    $hours = $now->format('H');

    if (($diff && $diff->d > 1) && $hours > $from && $hours < $to) return true;

    return false;
  }

  public function getHttp($url, $array = null)
  {
    $settings = (new BinanceHelpers)->getSettings();
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
