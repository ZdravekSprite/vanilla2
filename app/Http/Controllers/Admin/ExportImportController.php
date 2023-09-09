<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Day;
use App\Models\Euro;
use App\Models\Firm;
use App\Models\Holiday;
use App\Models\Month;
use App\Models\User;
use Illuminate\Http\Request;

class ExportImportController extends Controller
{
  public function export(Request $request)
  {
    if ($request->input('model') == 'euro') {
      $arrayData = Euro::orderBy('time', 'ASC')->get()->map(fn ($e) => [
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
      $arrayData = Holiday::orderBy('date', 'ASC')->get()->map(fn ($e) => [
        'date' => $e->date->format('Y-m-d'),
        'name' => $e->name,
      ]);
      $fileName = 'holidays.csv';
      //dd($arrayData,$fileName);
    }

    if ($request->input('model') == 'firm') {
      $arrayData = Firm::all()->map(fn ($e) => [
        'name' => $e->name,
        'address' => $e->address,
        'oib' => $e->oib,
        'iban' => $e->iban,
        'bank' => $e->bank,
        't01' => $e->t01,
        't02' => $e->t02,
        't03' => $e->t03,
        't04' => $e->t04,
        't05' => $e->t05,
        't06' => $e->t06,
        't07' => $e->t07,
        't08' => $e->t08,
        't09' => $e->t09,
        't10' => $e->t10,
        't11' => $e->t11,
        't12' => $e->t12,
        't13' => $e->t13,
      ]);
      $fileName = 'firms.csv';
    }

    if ($request->input('model') == 'user') {
      $arrayData = User::all()->map(fn ($e) => [
        'name' => $e->name,
        'email' => $e->email,
      ]);
      $fileName = 'users.csv';
    }

    if ($request->input('model') == 'month') {
      $months = Month::all();
      foreach ($months as $key => $value) {
        $value['user'] = $value->user()->name;
        $value['firm'] = $value->firm()->name;
      }
      $arrayData = $months->toArray();
      $fileName = 'months.csv';
      //dd($arrayData);
    }

    if ($request->input('model') == 'day') {
      $days = Day::all();
      foreach ($days as $key => $value) {
        $value['user'] = $value->user()->name;
        $value['firm'] = $value->firm()->name;
      }
      $arrayData = $days->setHidden(['id','user_id','firm_id','created_at','updated_at'])->toArray();
      $fileName = 'days.csv';
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

  public static function getCompanyId($company_name)
  {
    $firm = ExportImportController::getCompany($company_name);
    $firm_id = $firm ? $firm->id : 1;
    return $firm_id;
  }

  public static function getCompany($company_name)
  {
    $company_name = trim($company_name);
    if ($company_name == '') return null;
    $company = Firm::where('name', $company_name)->first();
    if (!$company) {
      $company = Firm::create([
        'name' => $company_name,
      ]);
    }
    return $company;
  }

  public static function getUserId($user_name)
  {
    $user = ExportImportController::getUser($user_name);
    $user_id = $user ? $user->id : 1;
    return $user_id;
  }

  public static function getUser($user_name)
  {
    $user_name = trim($user_name);
    if ($user_name == '') return null;
    $user = User::where('name', $user_name)->first();
    if (!$user) {
      $user = User::factory()->create([
        'name' => $user_name,
      ]);
    }
    return $user;
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
    if ($request->input('model') == 'day') {
      $columns = ['date', 'state', 'night', 'start', 'end', 'user', 'firm'];
    }
    if ($request->input('model') == 'firm') {
      $columns = ['name', 'address', 'oib', 'iban', 'bank', 't01', 't02', 't03', 't04', 't05', 't06', 't07', 't08', 't09', 't10', 't11', 't12', 't13'];
    }
    if ($request->input('model') == 'user') {
      $columns = ['name', 'email'];
    }
    if ($request->input('model') == 'month') {
      $columns = ['month', 'bruto', 'minuli', 'odbitak', 'prirez', 'prijevoz', 'prehrana', 'prekovremeni', 'stari', 'nocni', 'bolovanje', 'stimulacija', 'nagrada', 'regres', 'bozicnica', 'prigodna', 'sindikat', 'kredit', 'first', 'last', 'h01', 'v01', 'h02', 'v02', 'h03', 'v03', 'h04', 'v04', 'h05', 'v05', 'h06', 'v06', 'h07', 'v07', 'h08', 'v08', 'h09', 'v09', 'h10', 'v10', 'h11', 'v11', 'h12', 'v12', 'h13', 'v13', 'user', 'firm'];
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

        if ($request->input('model') == 'day') {
          $date = date("Y-m-d H:i:s", strtotime($dataRow['date']));
          $user_id = ExportImportController::getUserId($dataRow['user']);
          if (!Day::where('date', $date)->where('user_id', $user_id)->first()) {
            Day::insert([
              'date' => $date,
              'user_id' => $user_id,
              'firm_id' => ExportImportController::getCompanyId($dataRow['firm']),
              'state' => $dataRow['state'],
              'night' => $dataRow['night'],
              'start' => $dataRow['start'],
              'end' => $dataRow['end'],
            ]);
          }
        }

        if ($request->input('model') == 'firm') {
          $name = trim($dataRow['name']);
          if (!Firm::where('name', $name)->first()) {
            Firm::insert([
              'name' => $name,
            ]);
          }
        }

        if ($request->input('model') == 'user') {
          $user_name = trim($dataRow['name']);
          $user = User::where('name', $user_name)->first();
          if (!$user) {
            $user = User::factory()->create([
              'name' => $user_name,
              'email' => trim($dataRow['email']),
            ]);
          }
        }

        if ($request->input('model') == 'month') {
          //month,bruto,minuli,odbitak,prirez,prijevoz,prehrana,prekovremeni,stari,nocni,bolovanje,stimulacija,nagrada,regres,bozicnica,prigodna,sindikat,kredit,first,last,h01,v01,h02,v02,h03,v03,h04,v04,h05,v05,h06,v06,h07,v07,h08,v08,h09,v09,h10,v10,h11,v11,h12,v12,h13,v13,user,firm
          $user_id = ExportImportController::getUserId($dataRow['user']);
          $firm_id = ExportImportController::getCompanyId($dataRow['firm']);
          $month = Month::where('month', $dataRow['month'])->where('user_id', $user_id)->where('firm_id', $firm_id)->first();
          if (!$month) {
            $month = Month::create([
              'month' => $dataRow['month'],
              'user_id' => $user_id,
              'firm_id' => $firm_id,
            ]);
          }
          $month->bruto = (int)$dataRow['bruto'] ?? 0;
          $month->minuli = (int)$dataRow['minuli'] ?? 0;
          $month->odbitak = (int)$dataRow['odbitak'] ?? 0;
          $month->prirez = (int)$dataRow['prirez'] ?? 0;
          $month->prijevoz = (int)$dataRow['prijevoz'] ?? 0;
          $month->prehrana = (int)$dataRow['prehrana'] ?? 0;
          $month->prekovremeni = (int)$dataRow['prekovremeni'] ?? 0;
          $month->stari = (int)$dataRow['stari'] ?? 0;
          $month->nocni = (int)$dataRow['nocni'] ?? 0;
          $month->stimulacija = (int)$dataRow['stimulacija'] ?? 0;
          $month->nagrada = (int)$dataRow['nagrada'] ?? 0;
          $month->regres = (int)$dataRow['regres'] ?? 0;
          $month->bozicnica = (int)$dataRow['bozicnica'] ?? 0;
          $month->prigodna = (int)$dataRow['prigodna'] ?? 0;
          $month->kredit = (int)$dataRow['kredit'] ?? 0;
          $month->sindikat = (int)$dataRow['sindikat'] ?? 0;
          $month->first = $dataRow['first'];
          $month->last = $dataRow['last'];
          $month->h01 = $dataRow['h01'] ?? 0;
          $month->v01 = $dataRow['v01'] ?? 0;
          $month->h02 = $dataRow['h02'] ?? 0;
          $month->v02 = $dataRow['v02'] ?? 0;
          $month->h03 = $dataRow['h03'] ?? 0;
          $month->v03 = $dataRow['v03'] ?? 0;
          $month->h04 = $dataRow['h04'] ?? 0;
          $month->v04 = $dataRow['v04'] ?? 0;
          $month->h05 = $dataRow['h05'] ?? 0;
          $month->v05 = $dataRow['v05'] ?? 0;
          $month->h06 = $dataRow['h06'] ?? 0;
          $month->v06 = $dataRow['v06'] ?? 0;
          $month->h07 = $dataRow['h07'] ?? 0;
          $month->v07 = $dataRow['v07'] ?? 0;
          $month->h08 = $dataRow['h08'] ?? 0;
          $month->v08 = $dataRow['v08'] ?? 0;
          $month->h09 = $dataRow['h09'] ?? 0;
          $month->v09 = $dataRow['v09'] ?? 0;
          $month->h10 = $dataRow['h10'] ?? 0;
          $month->v10 = $dataRow['v10'] ?? 0;
          $month->h11 = $dataRow['h11'] ?? 0;
          $month->v11 = $dataRow['v11'] ?? 0;
          $month->h12 = $dataRow['h12'] ?? 0;
          $month->v12 = $dataRow['v12'] ?? 0;
          $month->h13 = $dataRow['h13'] ?? 0;
          $month->v13 = $dataRow['v13'] ?? 0;
          $month->save();
        }
      } else {
        $frstrow = false;
      }
    }
  }
}
