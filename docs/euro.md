# EuroJackPot

```bash
php artisan make:model Euro -a
```

- database\migrations\2023_08_01_000001_create_euros_table.php

```php
    Schema::create('euros', function (Blueprint $table) {
      $table->id();
      $table->date('time')->unique();
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

- resources\js\Pages\Euros.vue

```ts
<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
  <Head title="EuroJackPot" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">EuroJackPot</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">EuroJackPot!</div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
```

- app\Http\Controllers\EuroController.php

```php
use Inertia\Inertia;
  public function index()
  {
    return Inertia::render('Euros', [
      'euros' => [],
    ]);
  }
```

- routes\web.php

```php
use App\Http\Controllers\EuroController;
  Route::get('/euros', [EuroController::class, 'index'])->name('euros');
```

- resources\js\Layouts\AuthenticatedLayout.vue

```ts
              <!-- Navigation Links -->
                <NavLink :href="route('euros')" :active="route().current('euros')">
                  EuroJackPot
                </NavLink>
        <!-- Responsive Navigation Menu -->
            <ResponsiveNavLink :href="route('euros')" :active="route().current('euros')">
              EuroJackPot
            </ResponsiveNavLink>
```
