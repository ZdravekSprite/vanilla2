<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEarnRequest;
use App\Http\Requests\UpdateEarnRequest;
use App\Models\EarnFL;
use App\Models\EarnFP;
use App\Models\EarnLL;
use App\Models\EarnLP;
use App\Utils\BinanceHelpers;
use Inertia\Inertia;

class EarnController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $all = EarnLP::all()->count();
    $earn_f_p_s = EarnFP::select(['asset', 'totalAmount'])->paginate(5);
    $earn_f_l_s = EarnFL::select(['asset', 'latestAnnualPercentageRate'])->paginate(5);
    $earn_l_p_s = EarnLP::select(['asset', 'amount'])->paginate(5);
    $earn_l_l_s = EarnLL::select(['projectId', 'apr'])->paginate(5);
    return Inertia::render('Earns', [
      'all' => $all,
      'earn_l_p_s' => $earn_l_p_s,
      'earn_l_l_s' => $earn_l_l_s,
      'earn_f_p_s' => $earn_f_p_s,
      'earn_f_l_s' => $earn_f_l_s,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreEarnRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(EarnLP $earn)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(EarnLP $earn)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateEarnRequest $request, EarnLP $earn)
  {
    //dd($request);
    switch ($request->earn) {
      case 'SELP':
        return (new BinanceHelpers)->getSimpleEarnLockedPosition();
        //return (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/simple-earn/locked/position');
        //{ "total": 1, "rows": [ { "positionId": 205444680, "productId": "Bnb*120", "asset": "BNB", "amount": "0.4", "purchaseTime": 1688847427000, "duration": 120, "accrualDays": 48, "rewardAsset": "BNB", "rewardAmt": "0.00126004", "nextPay": "0.00002301", "nextPayDate": 1693094400000, "payPeriod": 1, "redeemAmountEarly": "0.39873996", "rewardsEndDate": 1699228800000, "deliverDate": 1699351200000, "redeemPeriod": 1, "canRedeemEarly": true, "autoSubscribe": false, "type": "NORMAL", "status": "HOLDING", "canReStake": true, "reStakeInfo": { "reStakeRate": "0.05", "reStakeAmount": "0.000063", "reStakeDuration": 90, "reStakeApr": "0.021", "estRewards": "0", "reStakeRewardsEndDate": 1699228800000, "reStakeDeliverDate": 1699351200000 }, "apy": "0.021" } ] 
        break;

      case 'SELL':
        return (new BinanceHelpers)->getSimpleEarnLockedList();
        //return (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/simple-earn/locked/list',['current' => 1,'size' => 100]);
        //{ "total": 262, "rows": [ { "projectId": "Axs*90", "detail": { "asset": "AXS", "rewardAsset": "AXS", "duration": 90, "renewable": true, "isSoldOut": true, "apr": "0.275", "status": "PURCHASING", "subscriptionStartTime": 1634040000000 }, "quota": { "totalPersonalQuota": "100", "minimum": "0.001" } }, { "projectId": "Axs*60", "detail": { "asset": "AXS", "rewardAsset": "AXS", "duration": 60, "renewable": true, "isSoldOut": true, "apr": "0.21", "status": "PURCHASING", "subscriptionStartTime": 1634040000000 }, "quota": { "totalPersonalQuota": "3000", "minimum": "0.001" } }, { "projectId": "Bsw*120", "detail": { "asset": "BSW", "rewardAsset": "BSW", "duration": 120, "renewable": true, "isSoldOut": false, "apr": "0.196", "status": "PURCHASING", "subscriptionStartTime": 1666872000000 }, "quota": { "totalPersonalQuota": "800", "minimum": "0.1" } }, { "projectId": "Ape*120", "detail": { "asset": "APE", "rewardAsset": "APE", "duration": 120, "renewable": true, "isSoldOut": false, "apr": "0.196", "status": "PURCHASING", "subscriptionStartTime": 1670587200000 }, "quota": { "totalPersonalQuota": "10000", "minimum": "0.1" } }, { "projectId": "Polyx*120", "detail": { "asset": "POLYX", "rewardAsset": "POLYX", "duration": 120, "renewable": true, "isSoldOut": false, "apr": "0.189", "status": "PURCHASING", "subscriptionStartTime": 1681992000000 }, "quota": { "totalPersonalQuota": "700", "minimum": "0.1" } }, { "projectId": "Ont*120", "detail": { "asset": "ONT", "duration": 120, "renewable": false, "isSoldOut": false, "status": "PURCHASING", "subscriptionStartTime": 1649931900000, "extraRewardAsset": "ONG", "extraRewardAPR": "0.188" }, "quota": { "totalPersonalQuota": "300", "minimum": "0.1" } }, { "projectId": "kava*120", "detail": { "asset": "KAVA", "rewardAsset": "KAVA", "duration": 120, "renewable": true, "isSoldOut": false, "apr": "0.179", "status": "PURCHASING", "subscriptionStartTime": 1656643560000 }, "quota": { "totalPersonalQuota": "800", "minimum": "0.1" } }, { "projectId": "Atom*120", "detail": { "asset": "ATOM", "rewardAsset": "ATOM", "duration": 120, "renewable": true, "isSoldOut": false, "apr": "0.179", "status": "PURCHASING", "subscriptionStartTime": 1647425340000 }, "quota": { "totalPersonalQuota": "10000", "minimum": "0.001" } }, { "projectId": "Ctk*90", "detail": { "asset": "CTK", "rewardAsset": "CTK", "duration": 90, "renewable": true, "isSoldOut": false, "apr": "0.169", "status": "PURCHASING", "subscriptionStartTime": 1643198400000 }, "quota": { "totalPersonalQuota": "700", "minimum": "1" } }, { "projectId": "Bsw*60", "detail": { "asset": "BSW", "rewardAsset": "BSW", "duration": 60, "renewable": true, "isSoldOut": false, "apr": "0.159", "status": "PURCHASING", "subscriptionStartTime": 1648814400000 }, "quota": { "totalPersonalQuota": "10000", "minimum": "0.1" } } ] }
        break;

      case 'SEFP':
        return (new BinanceHelpers)->getSimpleEarnFlexiblePosition();
        //return (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/simple-earn/flexible/position');
        //{ "total": 9, "rows": [ { "totalAmount": "149.28207486", "latestAnnualPercentageRate": "0.0060325", "asset": "ADA", "canRedeem": true, "collateralAmount": "0", "productId": "ADA001", "yesterdayRealTimeRewards": "0.00262139", "cumulativeBonusRewards": "0.03796557", "cumulativeRealTimeRewards": "0.13022403", "cumulativeTotalRewards": "0.75170066", "autoSubscribe": true }, { "totalAmount": "0.00492714", "tierAnnualPercentageRate": { "0-0.01BTC": "0.00250000" }, "latestAnnualPercentageRate": "0.00150625", "asset": "BTC", "canRedeem": true, "collateralAmount": "0", "productId": "BTC001", "yesterdayRealTimeRewards": "0.00000002", "cumulativeBonusRewards": "0.00000377", "cumulativeRealTimeRewards": "0.00000695", "cumulativeTotalRewards": "0.00017659", "autoSubscribe": true }, { "totalAmount": "254.98991446", "latestAnnualPercentageRate": "0.00719129", "asset": "BUSD", "canRedeem": true, "collateralAmount": "0", "productId": "BUSD001", "yesterdayRealTimeRewards": "0.00521436", "cumulativeBonusRewards": "0.303748", "cumulativeRealTimeRewards": "3.04637476", "cumulativeTotalRewards": "35.72322212", "autoSubscribe": true }, { "totalAmount": "2.81972274", "latestAnnualPercentageRate": "0.02200488", "asset": "DOT", "canRedeem": true, "collateralAmount": "0", "productId": "DOT001", "yesterdayRealTimeRewards": "0.0001705", "cumulativeBonusRewards": "0", "cumulativeRealTimeRewards": "0.00501539", "cumulativeTotalRewards": "0.01363592", "autoSubscribe": true }, { "totalAmount": "0.09227883", "tierAnnualPercentageRate": { "0-0.15ETH": "0.00250000" }, "latestAnnualPercentageRate": "0.00693786", "asset": "ETH", "canRedeem": true, "collateralAmount": "0", "productId": "ETH001", "yesterdayRealTimeRewards": "0.00000181", "cumulativeBonusRewards": "0.0000932", "cumulativeRealTimeRewards": "0.00026612", "cumulativeTotalRewards": "0.00184533", "autoSubscribe": true }, { "totalAmount": "0.49752566", "latestAnnualPercentageRate": "0.00306511", "asset": "LUNA", "canRedeem": true, "collateralAmount": "0", "productId": "LUNA001", "yesterdayRealTimeRewards": "0.0000047", "cumulativeBonusRewards": "0", "cumulativeRealTimeRewards": "0.00034694", "cumulativeTotalRewards": "0.01423612", "autoSubscribe": true }, { "totalAmount": "201.84927508", "latestAnnualPercentageRate": "0.00770971", "asset": "MATIC", "canRedeem": true, "collateralAmount": "0", "productId": "MATIC001", "yesterdayRealTimeRewards": "0.00444961", "cumulativeBonusRewards": "0.05911109", "cumulativeRealTimeRewards": "0.06981561", "cumulativeTotalRewards": "3.00969952", "autoSubscribe": true }, { "totalAmount": "2.79576485", "latestAnnualPercentageRate": "0.00480998", "asset": "SOL", "canRedeem": true, "collateralAmount": "0", "productId": "SOL001", "yesterdayRealTimeRewards": "0.00003376", "cumulativeBonusRewards": "0.00086422", "cumulativeRealTimeRewards": "0.00277093", "cumulativeTotalRewards": "0.02044085", "autoSubscribe": true }, { "totalAmount": "0.2552988", "latestAnnualPercentageRate": "0.05981608", "asset": "XMR", "canRedeem": true, "collateralAmount": "0", "productId": "XMR001", "yesterdayRealTimeRewards": "0.00003526", "cumulativeBonusRewards": "0", "cumulativeRealTimeRewards": "0.00101618", "cumulativeTotalRewards": "0.0032988", "autoSubscribe": true } ] }
        break;

      case 'SEFL':
        return (new BinanceHelpers)->getSimpleEarnFlexibleList();
        //return (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/simple-earn/flexible/list',['current' => 1,'size' => 100]);
        //{ "total": 356, "rows": [ { "asset": "SFP", "latestAnnualPercentageRate": "0.0808313", "canPurchase": true, "canRedeem": true, "isSoldOut": false, "hot": true, "minPurchaseAmount": "0.01", "productId": "SFP001", "subscriptionStartTime": 1622196085000, "status": "PURCHASING" }, { "asset": "LPT", "latestAnnualPercentageRate": "0.32053984", "canPurchase": true, "canRedeem": true, "isSoldOut": false, "hot": true, "minPurchaseAmount": "0.01", "productId": "LPT001", "subscriptionStartTime": 1625662697000, "status": "PURCHASING" }, { "asset": "AKRO", "latestAnnualPercentageRate": "0.13803514", "canPurchase": true, "canRedeem": true, "isSoldOut": false, "hot": true, "minPurchaseAmount": "10", "productId": "AKRO001", "subscriptionStartTime": 1651409708000, "status": "PURCHASING" }, { "asset": "CYBER", "latestAnnualPercentageRate": "0.09213581", "canPurchase": true, "canRedeem": true, "isSoldOut": false, "hot": true, "minPurchaseAmount": "0.01", "productId": "CYBER001", "subscriptionStartTime": 1691735645000, "status": "PURCHASING" }, { "asset": "BLZ", "latestAnnualPercentageRate": "0.18865625", "canPurchase": true, "canRedeem": true, "isSoldOut": false, "hot": true, "minPurchaseAmount": "1", "productId": "BLZ001", "subscriptionStartTime": 1654521805000, "status": "PURCHASING" }, { "asset": "RUNE", "latestAnnualPercentageRate": "0.16152619", "canPurchase": true, "canRedeem": true, "isSoldOut": false, "hot": true, "minPurchaseAmount": "0.1", "productId": "RUNE001", "subscriptionStartTime": 1638791490000, "status": "PURCHASING" }, { "asset": "LEVER", "latestAnnualPercentageRate": "0.05868538", "canPurchase": true, "canRedeem": true, "isSoldOut": false, "hot": true, "minPurchaseAmount": "10", "productId": "LEVER001", "subscriptionStartTime": 1657634892000, "status": "PURCHASING" }, { "asset": "BUSD", "latestAnnualPercentageRate": "0.00719181", "canPurchase": true, "canRedeem": true, "isSoldOut": false, "hot": false, "minPurchaseAmount": "0.1", "productId": "BUSD001", "subscriptionStartTime": 1571730389000, "status": "PURCHASING" }, { "asset": "APE", "latestAnnualPercentageRate": "0.08618734", "canPurchase": true, "canRedeem": true, "isSoldOut": false, "hot": false, "minPurchaseAmount": "0.1", "productId": "APE001", "subscriptionStartTime": 1647584163000, "status": "PURCHASING" }, { "asset": "AXS", "latestAnnualPercentageRate": "0.11069042", "canPurchase": true, "canRedeem": true, "isSoldOut": false, "hot": false, "minPurchaseAmount": "0.01", "productId": "AXS001", "subscriptionStartTime": 1627994647000, "status": "PURCHASING" } ] }
        break;

      default:
        # code...
        break;
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(EarnLP $earn)
  {
    //
  }
}
