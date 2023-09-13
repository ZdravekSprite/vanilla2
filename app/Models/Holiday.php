<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
  use HasFactory;

  protected $hidden = [
    'created_at',
    'updated_at',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    //'date' => 'datetime:d.m.Y',
    'date' => 'datetime:Y-m-d',
  ];
}
