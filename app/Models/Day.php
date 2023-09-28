<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
  use HasFactory;

  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  protected $fillable = [
    'date',
    'user_id',
    'state',
    'night',
    'start',
    'end',
    'firm_id',
  ];

  protected $casts = [
    'date' => 'datetime:Y-m-d',
    'night' => 'datetime:H:i',
    'start' => 'datetime:H:i',
    'end' => 'datetime:H:i',
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
   * Get the next night.
   */
  public function nextDay()
  {
    $next_date = $this->date->addDays(1)->format('Y-m-d');
    $next_day = Day::where('user_id', $this->user_id)->where('firm_id', $this->firm_id)->where('date', $next_date)->first();
    return $next_day;
  }
  /**
   * Get the next night.
   */
  public function nextNight()
  {
    $next_day = $this->nextDay();
    $next_night = $next_day ? $next_day->night->format('H:i') : $this->end;
    return $next_night;
  }

  public function stateDayBefore()
  {
    $dayBefore = Day::where('user_id', '=', $this->user_id)->where('date', '=', $this->date->addDays(-1)->format('Y-m-d'))->first();
    $stateDayBefore = $dayBefore ? $dayBefore->state : 0;
    return $stateDayBefore;
  }

  public function minutes($time)
  {
    //$minutes = $time->format('H') * 60 + $time->format('i');
    $minutes = $time->hour * 60 + $time->minute;
    return $minutes;
  }

  public function minWork()
  {
    if ($this->stateDayBefore() == 1) {
      $night = $this->night ? $this->minutes($this->night) : 0;
    } else {
      $night = 0;
    }
    if ($this->state == 1) {
      $startEnd = $this->start ? ($this->end ? $this->end->diffInMinutes($this->start) : 24 * 60 - $this->minutes($this->start)) : 0;
    } else {
      $startEnd = 0;
    }
    $day_minWork = $startEnd + $night;
    return $day_minWork;
  }

  public function minWorkNight()
  {
    if ($this->stateDayBefore() == 1) {
      $night = $this->night ? ($this->night->hour > 6 ? 360 : $this->minutes($this->night)) : 0;
    } else {
      $night = 0;
    }
    if ($this->state == 1) {
      $startMin = $this->start ? $this->minutes($this->start) : 0;
      $endMin = $this->end ? $this->minutes($this->end) : 0;
      if ($startMin > 0 && $endMin == 0) $endMin = 1440;
      // befor 6:00 (360 min)
      $start = $this->start ? ($startMin > 360 ? 0 : 360 - $startMin) : 0;
      // after 22:00 (1320 min)
      $end = $this->start ? ($startMin < 1320 ? ($endMin > 1320 ? $endMin - 1320 : 0) : $endMin - $startMin) : 0;
    } else {
      $start = 0;
      $end = 0;
    }
    $day_minWorkNight = $night + $start + $end;
    return $day_minWorkNight;
  }

}
