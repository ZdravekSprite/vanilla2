<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEarnRequest;
use App\Http\Requests\UpdateEarnRequest;
use App\Models\EarnLL;
use App\Models\EarnLP;
use Inertia\Inertia;

class EarnController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $all = EarnLP::all()->count();
    $earn_l_p_s = EarnLP::select(['asset', 'amount'])->paginate(5);
    $earn_l_l_s = EarnLL::select(['projectId', 'apr'])->paginate(5);
    return Inertia::render('Earns', [
      'all' => $all,
      'earn_l_p_s' => $earn_l_p_s,
      'earn_l_l_s' => $earn_l_l_s,
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
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(EarnLP $earn)
  {
    //
  }
}
