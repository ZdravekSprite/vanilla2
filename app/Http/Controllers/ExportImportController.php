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

  public function import(Request $request)
  {
    set_time_limit(0);
    $fileName = $request->fileName;
    $csvData = fopen(public_path('temp/' . $fileName), 'r');

    if ($request->input('model') == 'euro') {
      $columns = ['time', 'no1', 'no2', 'no3', 'no4', 'no5', 'bn1', 'bn2'];
    }
    if ($request->input('model') == 'holiday') {
      $columns = ['date', 'name'];
    }

    $frstrow = true;
    while (($data = fgetcsv($csvData, 555, ',')) !== false) {
      if (!$frstrow) {
        $dataRow = array_combine($columns, $data);

        if ($request->input('model') == 'euro') {
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
        }

        if ($request->input('model') == 'holiday') {
          $date = date("Y-m-d H:i:s", strtotime($dataRow['date']));
          if (!Holiday::where('date', $date)->first()) {
            Holiday::insert([
              'date' => $date,
              'name' => $dataRow['name'],
            ]);
          }
        }
      } else {
        $frstrow = false;
      }
    }
  }
}
