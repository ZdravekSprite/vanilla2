<?php

namespace App\Http\Controllers;

use App\Models\Euro;
use App\Http\Requests\StoreEuroRequest;
use App\Http\Requests\UpdateEuroRequest;
use Inertia\Inertia;

class EuroController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return Inertia::render('Euros', [
      'euros' => [],
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
  public function store(StoreEuroRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Euro $euro)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Euro $euro)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateEuroRequest $request, Euro $euro)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Euro $euro)
  {
    //
  }
}
