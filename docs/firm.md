# Firm

```bash
php artisan make:model Firm -a
```

- database\migrations\2023_08_09_000001_create_firms_table.php

```php
    Schema::create('euros', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->timestamps();
    });
```

- resources\js\Pages\Firms.vue
- app\Http\Controllers\FirmController.php
- routes\web.php
- resources\js\Layouts\AuthenticatedLayout.vue
- app\Http\Requests\StoreFirmRequest.php
- app\Http\Requests\UpdateFirmRequest.php
