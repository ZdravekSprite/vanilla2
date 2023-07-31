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
    $euros = Euro::select($selected)->get()->toArray();
    return Inertia::render('Euros', [
      'euros' => $euros,
    ]);
  }

  public function import(Request $request)
  {
    set_time_limit(0);
    $fileName = $request->fileName;
    $csvData = fopen(public_path('temp/' . $fileName), 'r');
    $columns = ['time', 'no1', 'no2', 'no3', 'no4', 'no5', 'bn1', 'bn2'];
    while (($data = fgetcsv($csvData, 555, ',')) !== false) {
      $dataRow = array_combine($columns, $data);
      if (!Euro::where('time', $dataRow['time'])->first()) {
        Euro::insert([
          'time' => $dataRow['time'],
          'no1' => $dataRow['no1'],
          'no2' => $dataRow['no2'],
          'no3' => $dataRow['no3'],
          'no4' => $dataRow['no4'],
          'no5' => $dataRow['no5'],
          'bn1' => $dataRow['bn1'],
          'bn2' => $dataRow['bn2'],
        ]);
      }
    }
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
