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
    $next = Month::orderBy('month', 'asc')->where('user_id', '=', $this->user_id)->where('month', '>', $this->month)->first();
    return $next ?? $this;
  }

  /**
   * Get the prev month.
   */
  public function prev()
  {
    $prev = Month::orderBy('month', 'desc')->where('user_id', '=', $this->user_id)->where('month', '<', $this->month)->first();
    return $prev ?? $this;
  }

  /**
   * Get the first day of month.
   */
  public function from()
  {
    $firstDate = '01.' . $this->slug();
    $from = CarbonImmutable::createFromFormat('d.m.Y', $firstDate)->firstOfMonth();
    $firstFrom = $this->user->settings->zaposlen > $from ? Carbon::parse($this->user->settings->zaposlen) : $from;
    return $firstFrom;
  }

  /**
   * Get the last day of month.
   */
  public function to()
  {
    $firstDate = '01.' . $this->slug();
    $to = Carbon::createFromFormat('d.m.Y', $firstDate)->endOfMonth();
    return $to;
  }

  public function days()
  {
    $firstDate = '01.' . $this->slug();
    $from = CarbonImmutable::createFromFormat('d.m.Y', $firstDate)->firstOfMonth();
    $to = Carbon::createFromFormat('d.m.Y', $firstDate)->endOfMonth();
    //dd($firstDate,$from,$to);
    $daysColection = Day::whereBetween('date', [$from, $to])->where('user_id', '=', $this->user_id)->get();
    $holidaysColection = Holiday::whereBetween('date', [$from, $to])->get();
    $datesArray = array();
    for ($i = 0; $i < $from->daysInMonth; $i++) {
      if ($daysColection->where('date', '=', $from->addDays($i))->first() != null) {
        $temp_date = $daysColection->where('date', '=', $from->addDays($i))->first();
      } else {
        $temp_date = new Day;
        $temp_date->date = $from->addDays($i);
        //dd($temp_date);
      }
      //$temp_date = $from->addDays($i);
      if ($holidaysColection->where('date', '=', $from->addDays($i))->first() != null) {
        //dd($holidaysColection->where('date', '=', $from->addDays($i))->first());
        $temp_date->holiday = $holidaysColection->where('date', '=', $from->addDays($i))->first()->name;
      }
      $datesArray[] = $temp_date;
    }
    $days = $datesArray;

    return $days;
  }
}
