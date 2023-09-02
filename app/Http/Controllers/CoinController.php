<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Http\Requests\StoreCoinRequest;
use App\Http\Requests\UpdateCoinRequest;
use Inertia\Inertia;
use App\Utils\BinanceHelpers;

class CoinController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $selected = ['coin', 'name'];
    $all = Coin::all()->count();
    $coins = Coin::select($selected)->paginate(15);
    return Inertia::render('Coins', [
      'all' => $all,
      'coins' => $coins,
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
  public function store(StoreCoinRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Coin $coin)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Coin $coin)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateCoinRequest $request, Coin $coin)
  {
    switch ($request->getAll) {
      case 'all':
        return (new BinanceHelpers)->getCapitalConfigGetall(true);
        break;

      default:
        # code...
        break;
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Coin $coin)
  {
    //
  }
}
