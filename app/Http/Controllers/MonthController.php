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
    $selected = ['id', 'month', 'user_id', 'bruto', 'minuli', 'odbitak', 'prirez', 'prijevoz', 'prehrana'];
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
    $m = Month::where('id', $month)->first();
    $days = $m->days();
    $c = $m->year() > 2022 ? ' €' : ' kn';
    foreach ($days as $key => $value) {
      $value['next_night'] = $value->nextNight();
    }
    return Inertia::render('Month', [
      'days' => $days,
      'data' => [
        'id' => $m->id,
        'slug' => $m->slug(),
        'bruto' => round((int)$m->bruto / 100, 2) . $c,
        'minuli' => round((int)$m->minuli / 100, 2) . ' %',
        'odbitak' => round((int)$m->odbitak / 100, 2) . $c,
        'prirez' => round((int)$m->prirez / 100, 2) . ' %',
        'prijevoz' => round((int)$m->prijevoz / 100, 2) . $c,
        'prehrana' => round((int)$m->prehrana / 100, 2) . $c,
        'stimulacija' => round((int)$m->stimulacija / 100, 2) . $c,
        'nagrada' => round((int)$m->nagrada / 100, 2) . $c,
        'regres' => round((int)$m->regres / 100, 2) . $c,
        'bozicnica' => round((int)$m->bozicnica / 100, 2) . $c,
        'prigodna' => round((int)$m->prigodna / 100, 2) . $c,
        'kredit' => round((int)$m->kredit / 100, 2) . $c,
        'sindikat' => round((int)$m->sindikat / 100, 2) . ' %',
        'first' => $m->first != "null" && $m->first != '' ? $m->first : $m->from(),
        'last' => $m->last != "null" && $m->last != '' ? $m->last : $m->to(),
        'h01' => round((float)$m->h01 / 100, 2) . '',
        'v01' => round((float)$m->v01 / 100, 2) . $c,
        'h02' => round((float)$m->h02 / 100, 2) . '',
        'v02' => round((float)$m->v02 / 100, 2) . $c,
        'h03' => round((float)$m->h03 / 100, 2) . '',
        'v03' => round((float)$m->v03 / 100, 2) . $c,
        'h04' => round((float)$m->h04 / 100, 2) . '',
        'v04' => round((float)$m->v04 / 100, 2) . $c,
        'h05' => round((float)$m->h05 / 100, 2) . '',
        'v05' => round((float)$m->v05 / 100, 2) . $c,
        'h06' => round((float)$m->h06 / 100, 2) . '',
        'v06' => round((float)$m->v06 / 100, 2) . $c,
        'h07' => round((float)$m->h07 / 100, 2) . '',
        'v07' => round((float)$m->v07 / 100, 2) . $c,
        'h08' => round((float)$m->h08 / 100, 2) . '',
        'v08' => round((float)$m->v08 / 100, 2) . $c,
        'h09' => round((float)$m->h09 / 100, 2) . '',
        'v09' => round((float)$m->v09 / 100, 2) . $c,
        'h10' => round((float)$m->h10 / 100, 2) . '',
        'v10' => round((float)$m->v10 / 100, 2) . $c,
        'h11' => round((float)$m->h11 / 100, 2) . '',
        'v11' => round((float)$m->v11 / 100, 2) . $c,
        'h12' => round((float)$m->h12 / 100, 2) . '',
        'v12' => round((float)$m->v12 / 100, 2) . $c,
        'h13' => round((float)$m->h13 / 100, 2) . '',
        'v13' => round((float)$m->v13 / 100, 2) . $c,
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
    $month = Month::findOrFail($request->id);
    $month->bruto = (int)((float)$request->bruto * 100);
    $month->minuli = (int)((float)$request->minuli * 100);
    $month->odbitak = (int)((float)$request->odbitak * 100);
    $month->prirez = (int)((float)$request->prirez * 100);
    $month->prijevoz = (int)((float)$request->prijevoz * 100);
    $month->prehrana = (int)((float)$request->prehrana * 100);
    $month->stimulacija = (int)((float)$request->stimulacija * 100);
    $month->nagrada = (int)((float)$request->nagrada * 100);
    $month->regres = (int)((float)$request->regres * 100);
    $month->bozicnica = (int)((float)$request->bozicnica * 100);
    $month->prigodna = (int)((float)$request->prigodna * 100);
    $month->kredit = (int)((float)$request->kredit * 100);
    $month->sindikat = (int)((float)$request->sindikat * 100);
    $month->first = $request->first;
    $month->last = $request->last;
    $month->h01 = (int)((float)$request->h01 * 100);
    $month->v01 = (int)((float)$request->v01 * 100);
    $month->h02 = (int)((float)$request->h02 * 100);
    $month->v02 = (int)((float)$request->v02 * 100);
    $month->h03 = (int)((float)$request->h03 * 100);
    $month->v03 = (int)((float)$request->v03 * 100);
    $month->h04 = (int)((float)$request->h04 * 100);
    $month->v04 = (int)((float)$request->v04 * 100);
    $month->h05 = (int)((float)$request->h05 * 100);
    $month->v05 = (int)((float)$request->v05 * 100);
    $month->h06 = (int)((float)$request->h06 * 100);
    $month->v06 = (int)((float)$request->v06 * 100);
    $month->h07 = (int)((float)$request->h07 * 100);
    $month->v07 = (int)((float)$request->v07 * 100);
    $month->h08 = (int)((float)$request->h08 * 100);
    $month->v08 = (int)((float)$request->v08 * 100);
    $month->h09 = (int)((float)$request->h09 * 100);
    $month->v09 = (int)((float)$request->v09 * 100);
    $month->h10 = (int)((float)$request->h10 * 100);
    $month->v10 = (int)((float)$request->v10 * 100);
    $month->h11 = (int)((float)$request->h11 * 100);
    $month->v11 = (int)((float)$request->v11 * 100);
    $month->h12 = (int)((float)$request->h12 * 100);
    $month->v12 = (int)((float)$request->v12 * 100);
    $month->h13 = (int)((float)$request->h13 * 100);
    $month->v13 = (int)((float)$request->v13 * 100);
    //dd($month);
    $month->save();
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
