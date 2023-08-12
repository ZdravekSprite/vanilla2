<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
  use HasFactory;

  protected $fillable = [
    'date',
    'user_id',
    'state',
    'night',
    'start',
    'end',
    'firm_id',
  ];
}
