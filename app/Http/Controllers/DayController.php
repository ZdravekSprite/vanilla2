<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Http\Requests\StoreDayRequest;
use App\Http\Requests\UpdateDayRequest;
use App\Models\Firm;
use App\Models\User;
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
    $perPage = 10;
    $selected = ['id', 'date', 'user_id', 'state', 'night', 'start', 'end', 'firm_id'];
    //$all = Day::whereUserId($user_id)->count();
    $days = Day::where('user_id', $user_id)->select($selected)->paginate($perPage);
    $all = Day::all()->count();
    //$days = Day::select($selected)->paginate($perPage);
    //dd($days);
    $states = [];
    foreach (['Nisam radio/la', 'Radio/la normalno', 'Godišnji', 'Plaćeni dopust', 'Bolovanje'] as $key => $value) {
      $states[] = (object) [
        'id' => $key,
        'name' => $value
      ];
    }

    //'Nisam radio', 'Radio normalno', 'Godišnji', 'Plaćeni dopust', 'Bolovanje';
    foreach ($days as $key => $value) {
      $value['_date'] = $value['date'];
      $value['firm'] = Firm::where('id', $value['firm_id'])->first()->name;
      $value['user'] = User::where('id', $value['user_id'])->first()->name;
      $value['state_id'] = $value['state'];
      $value['state'] = $states[$value['state_id']]->name;
    }
    return Inertia::render('Days', [
      'all' => $all,
      'days' => $days,
      'states' => $states,
      'firms' => Firm::all()->map(fn ($f) => [
        'id' => $f->id,
        'name' => $f->name,
      ]),
      'users' => User::all()->map(fn ($u) => [
        'id' => $u->id,
        'name' => $u->name,
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
    Day::factory()->create([
      'date' => $request->date,
      'user_id' => Auth::user()->id,
      'firm_id' => $request->firm,
      'state' => $request->state,
      'night' => $request->night,
      'start' => $request->start,
      'end' => $request->end,
    ]);
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
    $day = Day::where('user_id', $request->user_id)->where('date', date("Y-m-d H:i:s", strtotime($request->date)))->where('firm_id', $request->firm_id)->first();
    if (!$day) dd($request);
    $day->state = $request->state;
    $day->night = $request->night;
    $day->start = $request->start;
    $day->end = $request->end;
    $day->save();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Day $day)
  {
    //
  }
}
