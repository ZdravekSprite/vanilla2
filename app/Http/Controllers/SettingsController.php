<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Http\Requests\StoreSettingsRequest;
use App\Http\Requests\UpdateSettingsRequest;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
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
  public function store(StoreSettingsRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Settings $settings)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Settings $settings)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateSettingsRequest $request, Settings $settings)
  {
    //dd($request, $settings);
    $settings = Settings::where('user_id',Auth::user()->id)->first();
    if (!$settings) $settings = Settings::factory()->create([
      'user_id' => Auth::user()->id,
    ]);
    $settings->start1 = $request->start1;
    $settings->end1 = $request->end1;
    $settings->start2 = $request->start2;
    $settings->end2 = $request->end2;
    $settings->start3 = $request->start3;
    $settings->end3 = $request->end3;
    $settings->BINANCE_API_KEY = $request->key;
    $settings->BINANCE_API_SECRET = $request->secret;
    $settings->save();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Settings $settings)
  {
    //
  }
}
