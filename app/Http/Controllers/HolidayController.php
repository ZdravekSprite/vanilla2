<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Http\Requests\StoreHolidayRequest;
use App\Http\Requests\UpdateHolidayRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $selected = ['date', 'name'];
    $all = Holiday::all()->count();
    $holidays = Holiday::select($selected)->paginate(15);
    return Inertia::render('Holidays', [
      'all' => $all,
      'holidays' => $holidays,
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
  public function store(StoreHolidayRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Holiday $holiday)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Holiday $holiday)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateHolidayRequest $request, Holiday $holiday)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Holiday $holiday)
  {
    //
  }
}
