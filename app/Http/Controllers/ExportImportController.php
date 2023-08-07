<?php

namespace App\Http\Controllers;

use App\Models\Euro;
use App\Models\Holiday;
use Illuminate\Http\Request;

class ExportImportController extends Controller
{
  public function export(Request $request)
  {
    if ($request->input('model') == 'euro') {
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
    }

    if ($request->input('model') == 'holiday') {
      $arrayData = Holiday::all()->map(fn ($e) => [
        'date' => $e->date,
        'name' => $e->name,
      ]);
    }

    if (count($arrayData)) {
      $columns = array_keys($arrayData[0]);
      $file = fopen(public_path('temp/' . $fileName), 'w');
      fputcsv($file, $columns);
      foreach ($arrayData as $data) {
        fputcsv($file, $data);
      }
      fclose($file);
    }
  }
}
