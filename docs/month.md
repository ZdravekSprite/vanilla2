# Month

```bash
php artisan make:model Month -a
```

- database\migrations\2023_08_12_000002_create_months_table.php

```php
    Schema::create('months', function (Blueprint $table) {
      $table->id();
      $table->smallInteger('month');
      $table->foreignId('user_id')->constrained();
      $table->mediumInteger('bruto')->nullable();
      $table->tinyInteger('minuli')->nullable();
      $table->mediumInteger('odbitak')->nullable();
      $table->smallInteger('prirez')->nullable();
      $table->mediumInteger('prijevoz')->nullable();
      $table->mediumInteger('prehrana')->nullable();
      $table->tinyInteger('prekovremeni')->nullable();
      $table->smallInteger('stari')->nullable();
      $table->tinyInteger('nocni')->nullable();
      $table->mediumInteger('bolovanje')->nullable();
      $table->mediumInteger('stimulacija')->nullable();
      $table->mediumInteger('nagrada')->nullable();
      $table->mediumInteger('regres')->nullable();
      $table->mediumInteger('bozicnica')->nullable();
      $table->mediumInteger('prigodna')->nullable();
      $table->boolean('sindikat')->nullable();
      $table->mediumInteger('kredit')->nullable();
      $table->timestamps();
      $table->unique(['user_id', 'month']);
    });
```

- resources\js\Pages\Months.vue
- app\Http\Controllers\MonthController.php
- routes\web.php
- resources\js\Layouts\AuthenticatedLayout.vue
- app\Http\Requests\StoreMonthRequest.php
- app\Http\Requests\UpdateMonthRequest.php
