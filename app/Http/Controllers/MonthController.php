<?php

namespace App\Http\Controllers;

use App\Models\Month;
use App\Http\Requests\StoreMonthRequest;
use App\Http\Requests\UpdateMonthRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Decimal;

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
    //dd($m);
    return Inertia::render('Month', [
      'days' => $days,
      'data' => [
        'id' => $m->id,
        'slug' => $m->slug(),
        'valuta' => $c,
        'bruto' => round((int)$m->bruto / 100, 2),
        'minuli' => round((int)$m->minuli / 100, 2),
        'odbitak' => round((int)$m->odbitak / 100, 2),
        'prirez' => round((int)$m->prirez / 100, 2),
        'prijevoz' => round((int)$m->prijevoz / 100, 2),
        'prehrana' => round((int)$m->prehrana / 100, 2),
        'stimulacija' => round((int)$m->stimulacija / 100, 2),
        'nagrada' => round((int)$m->nagrada / 100, 2),
        'regres' => round((int)$m->regres / 100, 2),
        'bozicnica' => round((int)$m->bozicnica / 100, 2),
        'prigodna' => round((int)$m->prigodna / 100, 2),
        'kredit' => round((int)$m->kredit / 100, 2),
        'sindikat' => round((int)$m->sindikat / 100, 2),
        'first' => $m->first != "null" && $m->first != '' ? $m->first : $m->from(),
        'last' => $m->last != "null" && $m->last != '' ? $m->last : $m->to(),
        'h01' => round((float)$m->h01 / 100, 2),
        'v01' => round((float)$m->v01 / 100, 2),
        'h02' => round((float)$m->h02 / 100, 2),
        'v02' => round((float)$m->v02 / 100, 2),
        'h03' => round((float)$m->h03 / 100, 2),
        'v03' => round((float)$m->v03 / 100, 2),
        'h04' => round((float)$m->h04 / 100, 2),
        'v04' => round((float)$m->v04 / 100, 2),
        'h05' => round((float)$m->h05 / 100, 2),
        'v05' => round((float)$m->v05 / 100, 2),
        'h06' => round((float)$m->h06 / 100, 2),
        'v06' => round((float)$m->v06 / 100, 2),
        'h07' => round((float)$m->h07 / 100, 2),
        'v07' => round((float)$m->v07 / 100, 2),
        'h08' => round((float)$m->h08 / 100, 2),
        'v08' => round((float)$m->v08 / 100, 2),
        'h09' => round((float)$m->h09 / 100, 2),
        'v09' => round((float)$m->v09 / 100, 2),
        'h10' => round((float)$m->h10 / 100, 2),
        'v10' => round((float)$m->v10 / 100, 2),
        'h11' => round((float)$m->h11 / 100, 2),
        'v11' => round((float)$m->v11 / 100, 2),
        'h12' => round((float)$m->h12 / 100, 2),
        'v12' => round((float)$m->v12 / 100, 2),
        'h13' => round((float)$m->h13 / 100, 2),
        'v13' => round((float)$m->v13 / 100, 2),
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

  public function str2num(string $num)
  {
    $float = (float)$num;
    $int = $float*100;
    return (int)number_format($int, 0, '.', '');
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateMonthRequest $request, Month $month)
  {
    //dd($request);
    $month = Month::findOrFail($request->id);
    $month->bruto = (new MonthController)->str2num($request->bruto);
    $month->minuli = (new MonthController)->str2num($request->minuli);
    $month->odbitak = (new MonthController)->str2num($request->odbitak);
    $month->prirez = (new MonthController)->str2num($request->prirez);
    $month->prijevoz = (new MonthController)->str2num($request->prijevoz);
    $month->prehrana = (new MonthController)->str2num($request->prehrana);
    $month->stimulacija = (new MonthController)->str2num($request->stimulacija);
    $month->nagrada = (new MonthController)->str2num($request->nagrada);
    $month->regres = (new MonthController)->str2num($request->regres);
    $month->bozicnica = (new MonthController)->str2num($request->bozicnica);
    $month->prigodna = (new MonthController)->str2num($request->prigodna);
    $month->kredit = (new MonthController)->str2num($request->kredit);
    $month->sindikat = (new MonthController)->str2num($request->sindikat);
    $month->first = $request->first;
    $month->last = $request->last;
    $month->h01 = (new MonthController)->str2num($request->h01);
    $month->v01 = (new MonthController)->str2num($request->v01);
    $month->h02 = (new MonthController)->str2num($request->h02);
    $month->v02 = (new MonthController)->str2num($request->v02);
    $month->h03 = (new MonthController)->str2num($request->h03);
    $month->v03 = (new MonthController)->str2num($request->v03);
    $month->h04 = (new MonthController)->str2num($request->h04);
    $month->v04 = (new MonthController)->str2num($request->v04);
    $month->h05 = (new MonthController)->str2num($request->h05);
    $month->v05 = (new MonthController)->str2num($request->v05);
    $month->h06 = (new MonthController)->str2num($request->h06);
    $month->v06 = (new MonthController)->str2num($request->v06);
    $month->h07 = (new MonthController)->str2num($request->h07);
    $month->v07 = (new MonthController)->str2num($request->v07);
    $month->h08 = (new MonthController)->str2num($request->h08);
    $month->v08 = (new MonthController)->str2num($request->v08);
    $month->h09 = (new MonthController)->str2num($request->h09);
    $month->v09 = (new MonthController)->str2num($request->v09);
    $month->h10 = (new MonthController)->str2num($request->h10);
    $month->v10 = (new MonthController)->str2num($request->v10);
    $month->h11 = (new MonthController)->str2num($request->h11);
    $month->v11 = (new MonthController)->str2num($request->v11);
    $month->h12 = (new MonthController)->str2num($request->h12);
    $month->v12 = (new MonthController)->str2num($request->v12);
    $month->h13 = (new MonthController)->str2num($request->h13);
    $month->v13 = (new MonthController)->str2num($request->v13);
    //dd($month,$request);
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
