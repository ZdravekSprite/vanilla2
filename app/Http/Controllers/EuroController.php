<?php

namespace App\Http\Controllers;

use App\Models\Euro;
use App\Http\Requests\StoreEuroRequest;
use App\Http\Requests\UpdateEuroRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;

class EuroController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $selected = ['time', 'no1', 'no2', 'no3', 'no4', 'no5', 'bn1', 'bn2'];
    //$euros = Euro::select($selected)->get()->toArray();
    $all = Euro::all()->count();
    $euros = Euro::select($selected)->paginate(15);
    return Inertia::render('Euros', [
      'all' => $all,
      'euros' => $euros,
    ]);
  }

  public function import(Request $request)
  {
    set_time_limit(0);
    $fileName = $request->fileName;
    $csvData = fopen(public_path('temp/' . $fileName), 'r');
    $columns = ['time', 'no1', 'no2', 'no3', 'no4', 'no5', 'bn1', 'bn2'];
    $frstrow = true;
    while (($data = fgetcsv($csvData, 555, ',')) !== false) {
      if (!$frstrow) {
        $dataRow = array_combine($columns, $data);
        $date = date("Y-m-d H:i:s", strtotime($dataRow['time']));
        if (!Euro::where('time', $date)->first()) {
          Euro::insert([
            'time' => $date,
            'no1' => $dataRow['no1'],
            'no2' => $dataRow['no2'],
            'no3' => $dataRow['no3'],
            'no4' => $dataRow['no4'],
            'no5' => $dataRow['no5'],
            'bn1' => $dataRow['bn1'],
            'bn2' => $dataRow['bn2'],
          ]);
        }
      } else {
        $frstrow = false;
      }
    }
  }

  public function export(Request $request)
  {
    $arrayData = Euro::all()->map(fn ($e) => [
      'time' => $e->time,
      'no1' => $e->no1,
      'no2' => $e->no2,
      'no3' => $e->no3,
      'no4' => $e->no4,
      'no5' => $e->no5,
      'bn1' => $e->bn1,
      'bn2' => $e->bn2,
    ]);
    $fileName = 'euros.csv';
    $columns = array_keys($arrayData[0]);
    $file = fopen(public_path('temp/' . $fileName), 'w');
    fputcsv($file, $columns);
    foreach ($arrayData as $data) {
      fputcsv($file, $data);
    }
    fclose($file);
  }

  public function hl(Request $request)
  {
    $this->validate($request, [
      'datum' => 'required',
      'brojevi' => 'required'
    ]);
    //dd($request);
    $datum = date("Y-m-d H:i:s", strtotime($request->input('datum')));
    $brojevi = $request->input('brojevi');
    $no = explode( ',', explode( ';', $brojevi )[0] );
    $bn = explode( ',', explode( ';', $brojevi )[1] );
    $draw_exist = Euro::where('time', '=', $datum)->first();
    if ($draw_exist) {
      $draw_txt = $draw_exist->time . ": ";
      $draw_txt .= $draw_exist->no1 . ",";
      $draw_txt .= $draw_exist->no2 . ",";
      $draw_txt .= $draw_exist->no3 . ",";
      $draw_txt .= $draw_exist->no4 . ",";
      $draw_txt .= $draw_exist->no5 . ";";
      $draw_txt .= $draw_exist->bn1 . ",";
      $draw_txt .= $draw_exist->bn2;
      return "več postoji: " . $draw_txt . "(" . $datum . ":" . $brojevi . ")";
    } else {
      $draw = new Euro;
      $draw->time = date("Y-m-d H:i:s", strtotime($datum));
      $draw->no1 = $no[0];
      $draw->no2 = $no[1];
      $draw->no3 = $no[2];
      $draw->no4 = $no[3];
      $draw->no5 = $no[4];
      $draw->bn1 = $bn[0];
      $draw->bn2 = $bn[1];
      $draw->save();
    }
    return $datum . ":" . $brojevi;
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
