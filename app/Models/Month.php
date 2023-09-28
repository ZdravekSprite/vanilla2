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
    $firstOfMonth = CarbonImmutable::createFromFormat('d.m.Y', $firstDate)->firstOfMonth();
    $lastOfMonth = CarbonImmutable::createFromFormat('d.m.Y', $firstDate)->lastOfMonth();
    $first = $this->first ? Carbon::parse($this->first) : $firstOfMonth;
    $last = $this->last ? Carbon::parse($this->last) : $lastOfMonth;
    $is575 = $this->firm_id == 1;
    //dd($firstFrom);

    $hoursNormFull = 0; //580
    $hoursNormFull_575 = 0;
    $hoursNormAll = 0;
    $hoursNormAll_575 = 0;

    $hoursNormHoliFull = 0;
    $hoursNormHoliFull_575 = 0;
    $hoursNormHoliAll = 0;
    $hoursNormHoliAll_575 = 0;

    $minWork = 0;
    $minWorkNight = 0;
    $minWorkSunday = 0;
    $minWorkSundayNight = 0;
    $minWorkHoli = 0;
    $minWorkHoliNight = 0;
    $minWorkHoliSunday = 0;
    $minWorkHoliSundayNight = 0;

    foreach ($this->days() as $d) {
      $day_minWork = $d->minWork();
      $minWork += $day_minWork;
      $day_minWorkNight = $d->minWorkNight();
      $minWorkNight += $day_minWorkNight;

      $day_minWorkSunday = 0;
      $day_minWorkSundayNight = 0;

      $dayOfWeek = $d->date->dayOfWeek;
      switch ($dayOfWeek) {
        case 0:
          $def_h = 0;
          $def_575_h = 0;
          $day_minWorkSunday = $day_minWork;
          $day_minWorkSundayNight = $day_minWorkNight;
          $minWorkSunday += $day_minWorkSunday;
          $minWorkSundayNight += $day_minWorkSundayNight;
          break;
        case 6:
          $def_h = 0;
          $def_575_h = 5;
          break;
        default:
          $def_h = 8;
          $def_575_h = 7;
          break;
      }
      $hoursNormFull += $def_h;
      $hoursNormFull_575 += $def_575_h;

      if ($d->holiday) {
        $hoursNormHoliFull += $def_h;
        $hoursNormHoliFull_575 += $def_575_h;

        $minWorkHoli += $day_minWork;
        $minWorkHoliNight += $day_minWorkNight;
        $minWorkHoliSunday += $day_minWorkSunday;
        $minWorkHoliSundayNight += $day_minWorkSundayNight;
      }

      if ($first <= $d->date && $d->date <= $last) {
        $hoursNormAll += $def_h;
        $hoursNormAll_575 += $def_575_h;

        if ($d->holiday) {
          $hoursNormHoliAll += $def_h;
          $hoursNormHoliAll_575 += $def_575_h;
        }
      }
    }
    $data = (object) [
      'Full' => $is575 ? $hoursNormFull_575 : $hoursNormFull,
      'FullHoliday' => $is575 ? $hoursNormHoliFull_575 : $hoursNormHoliFull,
      'All' => $is575 ? $hoursNormAll_575 : $hoursNormAll,
      'Holiday' => $is575 ? $hoursNormHoliAll_575 : $hoursNormHoliAll,
      'min' => $minWork,
      'minNight' => $minWorkNight,
      'minSunday' => $minWorkSunday,
      'minSundayNight' => $minWorkSundayNight,
      'minHoli' => $minWorkHoli,
      'minHoliNight' => $minWorkHoliNight,
      'minHoliSunday' => $minWorkHoliSunday,
      'minHoliSundayNight' => $minWorkHoliSundayNight,
    ];
    return $data;
  }
}
