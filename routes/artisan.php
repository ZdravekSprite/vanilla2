<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::middleware('auth.admin')->group(function () {
  Route::get('reset', function () {
    Artisan::call('route:cache');
    return redirect(route('dashboard'))->with('success', 'php artisan route:cache success');
  })->name('reset');

  Route::get('migrate', function () {
    Artisan::call('migrate');
    return redirect(route('dashboard'))->with('success', 'Database migration success.');
  })->name('migrate');

  Route::get('fresh', function () {
    Artisan::call('migrate:fresh --seed');
    return redirect(route('dashboard'))->with('success', 'Database migration success.');
  })->name('fresh');
});
