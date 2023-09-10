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
}
