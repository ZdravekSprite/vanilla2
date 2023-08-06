# EuroJackPot

```bash
php artisan make:model Euro -a
```

- database\migrations\2023_08_01_000001_create_euros_table.php

```php
    Schema::create('euros', function (Blueprint $table) {
      $table->id();
      $table->dateTime('time')->unique();
      $table->tinyInteger('no1');
      $table->tinyInteger('no2');
      $table->tinyInteger('no3');
      $table->tinyInteger('no4');
      $table->tinyInteger('no5');
      $table->tinyInteger('bn1');
      $table->tinyInteger('bn2');
      $table->timestamps();
    });
```

```bash
php artisan migrate
```

- .gitignore

```text
/public/temp
```

- resources\js\Pages\Euros.vue
- app\Http\Controllers\EuroController.php
- routes\web.php
- resources\js\Layouts\AuthenticatedLayout.vue