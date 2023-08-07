<?php

use App\Http\Controllers\EuroController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
});

Route::get('/dashboard', function () {
  return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/euros', [EuroController::class, 'index'])->name('euros');
Route::post('/euro/import', [EuroController::class, 'import'])->name('euros.import');
Route::post('/euro/export', [EuroController::class, 'export'])->name('euros.export');
Route::get('/euro/hl', [EuroController::class, 'hl'])->name('euro.hl');

Route::get('/holidays', [HolidayController::class, 'index'])->name('holidays');
Route::post('/holiday/import', [HolidayController::class, 'import'])->name('holidays.import');
Route::post('/holiday/export', [HolidayController::class, 'export'])->name('holidays.export');

require __DIR__ . '/auth.php';
require __DIR__ . '/artisan.php';