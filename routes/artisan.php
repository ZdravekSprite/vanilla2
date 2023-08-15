<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::middleware('auth')->group(function () {
  Route::get('reset', function () {
    Artisan::call('route:cache');
    return redirect(route('dashboard'))->with('success', 'php artisan route:cache success');
  })->middleware(['auth'])->name('reset');

  Route::get('migrate', function () {
    Artisan::call('migrate');
    return redirect(route('dashboard'))->with('success', 'Database migration success.');
  })->middleware(['auth'])->name('migrate');

  Route::get('fresh', function () {
    Artisan::call('migrate:fresh --seed');
    return redirect(route('dashboard'))->with('success', 'Database migration success.');
  })->middleware(['auth'])->name('fresh');
});
