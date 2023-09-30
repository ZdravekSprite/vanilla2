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
    $hoursNormAll = 0;

    $hoursNormHoliFull = 0;
    $hoursNormHoliAll = 0;

    $minWork = 0;
    $minWorkNight = 0;
    $minWorkSunday = 0;
    $minWorkSundayNight = 0;
    $minWorkHoli = 0;
    $minWorkHoliNight = 0;
    $minWorkHoliSunday = 0;
    $minWorkHoliSundayNight = 0;

    foreach ($this->days() as $d) {
      $day_minWork = $d->minWork() - $d->minWorkNight();
      $day_minWorkNight = $d->minWorkNight();
      $day_minWorkSunday = 0;
      $day_minWorkSundayNight = 0;

      $dayOfWeek = $d->date->dayOfWeek;
      switch ($dayOfWeek) {
        case 0:
          $def_h = 0;
          $day_minWorkSunday = $day_minWork;
          $day_minWorkSundayNight = $day_minWorkNight;
          break;
        case 6:
          $def_h = 0;
          break;
        default:
          $def_h = 8;
          break;
      }

      if ($d->holiday) {
        $hoursNormHoliFull += $def_h;
        if ($day_minWorkSunday) {
          $minWorkHoliSunday += $day_minWorkSunday;
        } else {
          $minWorkHoli += $day_minWork;
        }
        if ($day_minWorkSundayNight) {
          $minWorkHoliSundayNight += $day_minWorkSundayNight;
        } else {
          $minWorkHoliNight += $day_minWorkNight;
        }
      } else {
        $hoursNormFull += $def_h;
        if ($day_minWorkSunday) {
          $minWorkSunday += $day_minWorkSunday;
        } else {
          $minWork += $day_minWork;
        }
        if ($day_minWorkSundayNight) {
          $minWorkSundayNight += $day_minWorkSundayNight;
        } else {
          $minWorkNight += $day_minWorkNight;
        }
      }


      if ($first <= $d->date && $d->date <= $last) {
        $hoursNormAll += $def_h;

        if ($d->holiday) {
          $hoursNormHoliAll += $def_h;
        }
      }
    }
    $All = $hoursNormAll;
    $Holiday = $hoursNormHoliAll;
    $allNotMin = $minWorkNight + $minWorkSunday + $minWorkSundayNight + $minWorkHoli + $minWorkHoliNight + $minWorkHoliSunday + $minWorkHoliSundayNight;
    $over = ($allNotMin + $minWork) / 60 - $All;
    $min = $over > 0 ? $All - $allNotMin / 60 : $minWork / 60;
    $data = (object) [
      'Full' => $hoursNormFull,
      'FullHoliday' => $hoursNormHoliFull,
      'All' => $All,
      'Holiday' => $Holiday,
      'min' => $min,
      'minNight' => $minWorkNight / 60,
      'minSunday' => $minWorkSunday / 60,
      'minSundayNight' => $minWorkSundayNight / 60,
      'minHoli' => $minWorkHoli / 60,
      'minHoliNight' => $minWorkHoliNight / 60,
      'minHoliSunday' => $minWorkHoliSunday / 60,
      'minHoliSundayNight' => $minWorkHoliSundayNight / 60,
      'over' => $over > 0 ? $over : 0,
    ];
    return $data;
  }
}
