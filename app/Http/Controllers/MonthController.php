<?php

namespace App\Http\Controllers;

use App\Models\Month;
use App\Http\Requests\StoreMonthRequest;
use App\Http\Requests\UpdateMonthRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MonthController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $selected = ['id', 'month'];
    $all = Month::all()->count();
    $months = Month::select($selected)->paginate(14);
    foreach ($months as $key => $value) {
      $value['slug'] = $value->slug();
    }
    return Inertia::render('Months', [
      'all' => $all,
      'months' => $months,
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
  public function store(StoreMonthRequest $request)
  {
    $this->validate($request, [
      'month' => 'required',
      'year' => 'required'
    ]);
    $month = new Month;
    $month->month = $request->input('month') - 1 + $request->input('year') * 12;
    $month->user_id = Auth::user()->id;
    $old_month = Month::where('user_id', $month->user_id)->where('month', '=', $month->month)->first();
    if ($old_month) return redirect(route('months.edit', ['month' => $month->slug()]))->with('new_month', $month)->with('warning', 'Day already exist');
    $month->save();
  }

  /**
   * Display the specified resource.
   */
  public function show(Month $month)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Month $month)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateMonthRequest $request, Month $month)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Month $month)
  {
    //
  }
}
