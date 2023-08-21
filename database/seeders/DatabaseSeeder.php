<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // \App\Models\User::factory(10)->create();

    $super_admin = User::where('email', env('SUPER_ADMIN_EMAIL', 'super@admin.com'))->first();
    if (!$super_admin) User::factory()->create([
      'name' => env('SUPER_ADMIN_NAME', 'Super admin'),
      'email' =>  env('SUPER_ADMIN_EMAIL', 'super@admin.com'),
      'password' => Hash::make(env('SUPER_ADMIN_PASS', 'password')),
    ]);
    $this->call(RoleSeeder::class);
    $this->call(SettingsSeeder::class);
  }
}
