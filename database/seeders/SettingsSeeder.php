<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SettingsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Settings::truncate();
    $super_admin = User::where('email', env('SUPER_ADMIN_EMAIL', 'super@admin.com'))->first();
    if (!$super_admin) $super_admin = User::create([
      'name' => env('SUPER_ADMIN_NAME', 'Super Admin'),
      'email' =>  env('SUPER_ADMIN_EMAIL', 'super@admin.com'),
      'password' => Hash::make(env('SUPER_ADMIN_PASS', 'password')),
    ]);
    $super_admin_settings = Settings::create([
      'user_id' => $super_admin->id,
    ]);
    $super_admin_settings->BINANCE_API_KEY = env('BINANCE_API_KEY', '');
    $super_admin_settings->BINANCE_API_SECRET = env('BINANCE_API_SECRET', '');
    $super_admin->save();
  }
}
