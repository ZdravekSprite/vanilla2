<?php

namespace App\Utils;

use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BinanceHelpers
{
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
