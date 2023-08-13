# Day

```bash
php artisan make:model Day -a
```

- database\migrations\2023_08_12_000001_create_days_table.php

```php
    Schema::create('days', function (Blueprint $table) {
      $table->id();
      $table->date('date');
      $table->foreignId('user_id')->constrained();
      $table->foreignId('firm_id')->constrained();
      $table->boolean('state')->default(0);
      $table->time('night')->nullable();
      $table->time('start')->nullable();
      $table->time('end')->nullable();
      $table->timestamps();
      $table->unique(['user_id', 'date']);
    });
```

- resources\js\Pages\Days.vue
- app\Http\Controllers\DayController.php
- routes\web.php
- resources\js\Layouts\AuthenticatedLayout.vue
- app\Http\Requests\StoreDayRequest.php
- app\Http\Requests\UpdateDayRequest.php
