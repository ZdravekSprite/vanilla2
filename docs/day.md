# Day

```bash
php artisan make:model Day -a
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

- resources\js\Pages\Days.vue
- app\Http\Controllers\DayController.php
- routes\web.php
- resources\js\Layouts\AuthenticatedLayout.vue
- app\Http\Requests\StoreDayRequest.php
- app\Http\Requests\UpdateDayRequest.php
