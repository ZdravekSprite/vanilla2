<?php

use App\Http\Controllers\Admin\ExportImportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\EuroController;
use App\Http\Controllers\EarnController;
use App\Http\Controllers\FirmController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\MonthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SymbolController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Utils\BinanceHelpers;

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
  $binance = (new BinanceHelpers)->getBinanceData();
  if (!$binance) return Inertia::render('Dashboard');
  $sum = $binance->reduce(function ($sum, $value) {
    return $sum + ($value['all'] * $value['price']);
  });
  $free = $binance->reduce(function ($free, $value) {
    return $free + $value['free'];
  });
  $locked = $binance->reduce(function ($locked, $value) {
    return $locked + $value['locked'];
  });
  $symbols = (new BinanceHelpers)->exchangeInfo();
  return Inertia::render('Dashboard', [
    'binance' => [$binance, $sum, [$free > 0, $locked > 0], $symbols],
  ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/euro/hl', [EuroController::class, 'hl'])->name('euro.hl');

Route::middleware('auth')->group(function () {
  Route::get('/user/stop', [UserController::class, 'stop'])->name('user.stop');

  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  //Route::resource('settings', SettingsController::class);
  Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');

  Route::get('/euros', [EuroController::class, 'index'])->name('euros');

  Route::get('/holidays', [HolidayController::class, 'index'])->name('holidays');

  Route::get('/days', [DayController::class, 'index'])->name('days');
  Route::post('/day', [DayController::class, 'store'])->name('day.store');
  Route::patch('/day', [DayController::class, 'update'])->name('day.update');
  Route::delete('/day', [DayController::class, 'destroy'])->name('day.destroy');

  Route::get('/months', [MonthController::class, 'index'])->name('months');
  Route::get('/month/{id}', [MonthController::class, 'show'])->name('month');
  Route::post('/month', [MonthController::class, 'store'])->name('month.store');
  Route::patch('/month', [MonthController::class, 'update'])->name('month.update');
  Route::delete('/month', [MonthController::class, 'destroy'])->name('month.destroy');

  Route::get('/coins', [CoinController::class, 'index'])->name('coins');
  Route::post('/coin', [CoinController::class, 'update'])->name('coin.update');

  Route::get('/earns', [EarnController::class, 'index'])->name('earns');
  Route::post('/earn', [EarnController::class, 'update'])->name('earn.update');

  Route::get('/symbols', [SymbolController::class, 'index'])->name('symbols');
  Route::post('/symbol', [SymbolController::class, 'update'])->name('symbol.update');
});

Route::middleware('auth.admin')->group(function () {
  Route::get('/user/{user}', [UserController::class, 'start'])->name('user.start');

  Route::post('/holiday', [HolidayController::class, 'store'])->name('holiday.store');
  Route::patch('/holiday', [HolidayController::class, 'update'])->name('holiday.update');
  Route::delete('/holiday', [HolidayController::class, 'destroy'])->name('holiday.destroy');

  Route::post('/export', [ExportImportController::class, 'export'])->name('export');
  Route::post('/import', [ExportImportController::class, 'import'])->name('import');

  Route::get('/roles', [RoleController::class, 'index'])->name('roles');
  Route::post('/role', [RoleController::class, 'store'])->name('role.store');
  Route::patch('/role/{role}', [RoleController::class, 'update'])->name('role.update');
  Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('role.destroy');

  Route::get('/users', [UserController::class, 'index'])->name('users');
  Route::post('/user', [UserController::class, 'store'])->name('user.store');
  Route::patch('/user', [UserController::class, 'update'])->name('user.update');
  Route::delete('/user', [UserController::class, 'destroy'])->name('user.destroy');

  Route::get('/firms', [FirmController::class, 'index'])->name('firms');
  Route::post('/firm', [FirmController::class, 'store'])->name('firm.store');
  Route::patch('/firm', [FirmController::class, 'update'])->name('firm.update');
  Route::delete('/firm', [FirmController::class, 'destroy'])->name('firm.destroy');
});
require __DIR__ . '/auth.php';
require __DIR__ . '/artisan.php';
