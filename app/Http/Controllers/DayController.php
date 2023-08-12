<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Http\Requests\StoreDayRequest;
use App\Http\Requests\UpdateDayRequest;
use App\Models\Firm;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class DayController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $user_id = Auth::user()->id;
    $selected = ['id', 'date', 'user_id', 'state', 'night', 'start', 'end', 'firm_id'];
    //$all = Day::whereUserId($user_id)->count();
    //$days = Day::whereUserId($user_id)->select($selected)->paginate(15);
    $all = Day::all()->count();
    $days = Day::select($selected)->paginate(15);
    return Inertia::render('Days', [
      'all' => $all,
      'days' => $days,
      'firms' => Firm::all()->map(fn ($s) => [
        'id' => $s->id,
        'name' => $s->name,
      ]),
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
  public function store(StoreDayRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Day $day)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Day $day)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateDayRequest $request, Day $day)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Day $day)
  {
    //
  }
}
