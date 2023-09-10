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

}
