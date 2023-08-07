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

  public function import(Request $request)
  {
    set_time_limit(0);
    $fileName = $request->fileName;
    $csvData = fopen(public_path('temp/' . $fileName), 'r');
    $columns = ['date', 'name'];
    $frstrow = true;
    while (($data = fgetcsv($csvData, 555, ',')) !== false) {
      if (!$frstrow) {
        $dataRow = array_combine($columns, $data);
        $date = date("Y-m-d H:i:s", strtotime($dataRow['date']));
        if (!Holiday::where('date', $date)->first()) {
          Holiday::insert([
            'date' => $date,
            'name' => $dataRow['name'],
          ]);
        }
      } else {
        $frstrow = false;
      }
    }
  }

  public function export(Request $request)
  {
    $arrayData = Holiday::all()->map(fn ($e) => [
      'date' => $e->date,
      'name' => $e->name,
    ]);
    if (count($arrayData)) {
      $fileName = $request->fileName;
      $columns = array_keys($arrayData[0]);
      $file = fopen(public_path('temp/' . $fileName), 'w');
      fputcsv($file, $columns);
      foreach ($arrayData as $data) {
        fputcsv($file, $data);
      }
      fclose($file);
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
