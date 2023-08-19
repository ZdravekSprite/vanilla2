<?php

namespace App\Http\Controllers;

use App\Models\Month;
use App\Http\Requests\StoreMonthRequest;
use App\Http\Requests\UpdateMonthRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonthController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $selected = ['id', 'month', 'user_id', 'bruto'];
    //$all = Month::where('user_id',Auth::user()->id)->count();
    $months = Month::where('user_id', Auth::user()->id)->select($selected)->paginate(14);
    $all = Month::all()->count();
    //$months = Month::select($selected)->paginate(14);
    foreach ($months as $key => $value) {
      $value['slug'] = $value->slug();
      $value['user'] = $value->user()->name;
      $value['_month'] = $value->month();
      $value['_year'] = $value->year();
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
      '_month' => 'required',
      '_year' => 'required'
    ]);
    $month = new Month;
    $month->month = $request->input('_month') - 1 + $request->input('_year') * 12;
    $month->user_id = Auth::user()->id;
    $old_month = Month::where('user_id', $month->user_id)->where('month', '=', $month->month)->first();
    if ($old_month) return redirect(route('months.edit', ['month' => $month->slug()]))->with('new_month', $month)->with('warning', 'Manth already exist');
    $month->save();
  }

  /**
   * Display the specified resource.
   */
  //public function show(Month $month)
  public function show(Int $month)
  {
    //dd($month);
    $user_id = Auth::user()->id;
    $m = Month::where('id', $month)->first();
    $c = $m->year() >2022 ? ' €' : ' kn';
    //dd($month,$m);
    return Inertia::render('Month', [
      'month' => $m->days(),
      'data' => [
        'id'=> $m->id,
        'slug' => $m->slug(),
        'bruto' => round($m->bruto/100, 2) . $c,
        'minuli' => round($m->minuli/100, 2) . ' %',
        'odbitak' => round($m->odbitak/100, 2) . $c,
        'prirez' => round($m->prirez/100, 2) . ' %',
        'prijevoz' => round($m->prijevoz/100, 2) . $c,
        'prehrana' => round($m->prehrana/100, 2) . $c,
        'stimulacija' => round($m->stimulacija/100, 2) . $c,
        'nagrada' => round($m->nagrada/100, 2) . $c,
        'regres' => round($m->regres/100, 2) . $c,
        'bozicnica' => round($m->bozicnica/100, 2) . $c,
        'prigodna' => round($m->prigodna/100, 2) . $c,
        'kredit' => round($m->kredit/100, 2) . $c,
        'sindikat' => round($m->sindikat/100, 2) . ' %',
        'h01' => $m->h01 . '',
        'v01' => round($m->v01/100, 2) . $c,
        'h02' => $m->h02 . '',
        'v02' => round($m->v02/100, 2) . $c,
        'h03' => $m->h03 . '',
        'v03' => round($m->v03/100, 2) . $c,
        'h04' => $m->h04 . '',
        'v04' => round($m->v04/100, 2) . $c,
        'h05' => $m->h05 . '',
        'v05' => round($m->v05/100, 2) . $c,
        'h06' => $m->h06 . '',
        'v06' => round($m->v06/100, 2) . $c,
        'h07' => $m->h07 . '',
        'v07' => round($m->v07/100, 2) . $c,
        'h08' => $m->h08 . '',
        'v08' => round($m->v08/100, 2) . $c,
        'h09' => $m->h09 . '',
        'v09' => round($m->v09/100, 2) . $c,
        'h10' => $m->h10 . '',
        'v10' => round($m->v10/100, 2) . $c,
        'h11' => $m->h11 . '',
        'v11' => round($m->v11/100, 2) . $c,
      ],
      'next' => $m->next()->slug(),
      'prev' => $m->prev()->slug(),
      'next_id' => $m->next()->id,
      'prev_id' => $m->prev()->id,
    ]);
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
  //public function destroy(Month $month)
  public function destroy(Request $request)
  {
    //dd($request->id);
    $month = month::findOrFail($request->id);
    //dd($month);
    $month->delete();
  }
}
