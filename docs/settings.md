# Settings

```bash
php artisan make:model Settings -a
```

- database\migrations\2023_08_21_000001_create_settings_table.php

```php
    Schema::create('settings', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->string('BINANCE_API_KEY')->unique()->nullable();
      $table->string('BINANCE_API_SECRET')->unique()->nullable();
      $table->timestamps();
    });
```

- .env
- database\seeders\DatabaseSeeder.php
- database\seeders\SettingsSeeder.php
- app\Models\Settings.php
- app\Http\Controllers\SettingsController.php
- app\Http\Requests\StoreSettingsRequest.php
- app\Http\Requests\UpdateSettingsRequest.php
