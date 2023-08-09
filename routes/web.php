<?php

use App\Http\Controllers\Admin\ExportImportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\EuroController;
use App\Http\Controllers\FirmController;
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
})->name('home');

Route::get('/dashboard', function () {
  return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/euros', [EuroController::class, 'index'])->name('euros');
Route::get('/euro/hl', [EuroController::class, 'hl'])->name('euro.hl');

Route::get('/holidays', [HolidayController::class, 'index'])->name('holidays');
Route::post('/holiday', [HolidayController::class, 'store'])->name('holiday.store');
Route::patch('/holiday', [HolidayController::class, 'update'])->name('holiday.update');
Route::delete('/holiday', [HolidayController::class, 'destroy'])->name('holiday.destroy');

Route::post('/export', [ExportImportController::class, 'export'])->name('export');
Route::post('/import', [ExportImportController::class, 'import'])->name('import');

Route::get('/users', [UserController::class, 'index'])->name('users');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::patch('/user', [UserController::class, 'update'])->name('user.update');
Route::delete('/user', [UserController::class, 'destroy'])->name('user.destroy');

Route::get('/firms', [FirmController::class, 'index'])->name('firms');
Route::post('/firm', [FirmController::class, 'store'])->name('firm.store');
Route::patch('/firm', [FirmController::class, 'update'])->name('firm.update');
Route::delete('/firm', [FirmController::class, 'destroy'])->name('firm.destroy');

require __DIR__ . '/auth.php';
require __DIR__ . '/artisan.php';
