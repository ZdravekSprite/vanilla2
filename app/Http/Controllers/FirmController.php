<?php

namespace App\Http\Controllers;

use App\Models\Firm;
use App\Http\Requests\StoreFirmRequest;
use App\Http\Requests\UpdateFirmRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;

class FirmController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $selected = ['id', 'name'];
    $all = Firm::all()->count();
    $firms = Firm::select($selected)->paginate(15);
    return Inertia::render('Firms', [
      'all' => $all,
      'firms' => $firms,
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
  public function store(StoreFirmRequest $request)
  {
    Firm::factory()->create([
      'name' => $request->name,
    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show(Firm $firm)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Firm $firm)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateFirmRequest $request, Firm $firm)
  {
    $firm = Firm::findOrFail($request->id);
    $firm->name = $request->name;
    $firm->save();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request, Firm $firm)
  {
    //dd($request);
    //$firm = Firm::findOrFail($request->id);
    //dd($firm);
    $firm->delete();
  }
}
