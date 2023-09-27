<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;

class Month extends Model
{
  use HasFactory;

  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  protected $fillable = [
    'month',
    'user_id',
    'firm_id',
  ];

  /**
   * Get the user that owns the month.
   */
  public function user()
  {
    return $this->belongsTo(User::class)->first();
  }

  /**
   * Get the firm that owns the month.
   */
  public function firm()
  {
    return $this->belongsTo(Firm::class)->first();
  }

  /**
   * Get the month slug.
   */
  public function month()
  {
    $m = $this->month % 12 + 1;
    return $m;
  }

  /**
   * Get the month slug.
   */
  public function year()
  {
    $y = ($this->month - $this->month % 12) / 12;
    return $y;
  }

  /**
   * Get the month slug.
   */
  public function slug()
  {
    return sprintf("%02d.%04d", $this->month(), $this->year());
  }

  /**
   * Get the next month.
   */
  public function next()
  {
    $next = Month::orderBy('month', 'asc')->where('user_id', $this->user_id)->where('id', '>', $this->id)->first();
    return $next ?? $this;
  }

  /**
   * Get the prev month.
   */
  public function prev()
  {
    $prev = Month::orderBy('month', 'desc')->where('user_id', $this->user_id)->where('id', '<', $this->id)->first();
    return $prev ?? $this;
  }

  /**
   * Get the first day of month.
   */
  public function from()
  {
    $firstDate = '01.' . $this->slug();
    $from = CarbonImmutable::createFromFormat('d.m.Y', $firstDate)->firstOfMonth();
    /*$firstFrom = $this->user->settings->zaposlen > $from ? Carbon::parse($this->user->settings->zaposlen) : $from;
    return $firstFrom;*/
    return $from->format('Y-m-d');
  }

  /**
   * Get the last day of month.
   */
  public function to()
  {
    $firstDate = '01.' . $this->slug();
    $to = Carbon::createFromFormat('d.m.Y', $firstDate)->endOfMonth();
    return $to->format('Y-m-d');
  }

  /**
   * Get the days of month.
   */
  public function days()
  {
    $firstDate = '01.' . $this->slug();
    $from = CarbonImmutable::createFromFormat('d.m.Y', $firstDate)->firstOfMonth();
    $to = Carbon::createFromFormat('d.m.Y', $firstDate)->endOfMonth();
    $daysColection = Day::whereBetween('date', [$from->addDays(-1), $to])->where('user_id', $this->user_id)->get();
    $holidaysColection = Holiday::whereBetween('date', [$from->addDays(-1), $to])->get();
    $datesArray = array();
    for ($i = 0; $i < $from->daysInMonth; $i++) {
      if ($daysColection->where('date', $from->addDays($i))->first() != null) {
        $temp_date = $daysColection->where('date', $from->addDays($i))->first();
      } else {
        $temp_date = new Day;
        $temp_date->date = $from->addDays($i);
        $temp_date->user_id = $this->user_id;
        $temp_date->user = $this->user()->name;
        $temp_date->firm_id = $this->firm_id;
        $temp_date->firm = $this->firm()->name;
      }
      if ($holidaysColection->where('date', $from->addDays($i))->first() != null) {
        $temp_date->holiday = $holidaysColection->where('date', $from->addDays($i))->first()->name;
      }
      $datesArray[] = $temp_date;
    }
    $days = $datesArray;
    return $days;
  }

  /**
   * Get the hours Norm of month.
   */
  public function data()
  {
    $firstDate = '01.' . $this->slug();
    $from = CarbonImmutable::createFromFormat('d.m.Y', $firstDate)->firstOfMonth();

    $hoursNormAll = 0;

    foreach ($this->days() as $d) {
      $dayOfWeek = $d->date->dayOfWeek;
      switch ($dayOfWeek) {
        case 0:
          $def_h = 0;
          break;
        case 6:
          $def_h = 0;
          break;
        default:
          $def_h = 8;
          break;
      }
      $hoursNormAll += $def_h;
    }
    $data = (object) [
      'All' => $hoursNormAll,
    ];
    return $data;
  }
}
