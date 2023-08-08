# Holiday

```bash
php artisan make:model Holiday -a
```

- database\migrations\2023_08_06_000001_create_holidays_table.php

```php
    Schema::create('holidays', function (Blueprint $table) {
      $table->id();
      $table->date('date')->unique();
      $table->string('name');
      $table->timestamps();
    });
```

- resources\js\Pages\Holidays.vue
- app\Http\Controllers\HolidayController.php
- routes\web.php
- resources\js\Layouts\AuthenticatedLayout.vue
- app\Http\Requests\StoreHolidayRequest.php
- app\Http\Requests\UpdateHolidayRequest.php
