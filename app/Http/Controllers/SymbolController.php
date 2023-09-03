<?php

namespace App\Http\Controllers;

use App\Models\Symbol;
use App\Http\Requests\StoreSymbolRequest;
use App\Http\Requests\UpdateSymbolRequest;
use Inertia\Inertia;
use App\Utils\BinanceHelpers;

class SymbolController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $all = Symbol::all()->count();
    $symbols = Symbol::select(['id','symbol', 'status'])->paginate(15);
    return Inertia::render('Symbols', [
      'all' => $all,
      'symbols' => $symbols,
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
  public function store(StoreSymbolRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Symbol $symbol)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Symbol $symbol)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateSymbolRequest $request, Symbol $symbol)
  {
    switch ($request->getAll) {
      case 'all':
        return (new BinanceHelpers)->exchangeInfo(true);
        break;

      default:
        # code...
        break;
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Symbol $symbol)
  {
    //
  }
}
