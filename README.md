# Breeze

```bash
composer create-project laravel/laravel vanilla2
touch database/database.sqlite
```

- .gitignore

```text
/public/temp
```

- .env

```edit
APP_NAME="Vanilla2"
DB_CONNECTION=sqlite
```

```bash
composer require laravel/breeze --dev
php artisan breeze:install
php artisan migrate
```

## Dashboard

- resources\js\Pages\Dashboard.vue

```js
import { computed } from 'vue'
import { Head, usePage } from '@inertiajs/vue3';

const user = computed(() => usePage().props.auth.user)

          <div class="p-6 text-gray-900 dark:text-gray-100">You're logged in as: {{ user.name }}!</div>
```

## Login

- app\Http\Controllers\Auth\AuthenticatedSessionController.php

```js
  public function create(): Response
  {
    return Inertia::render('Auth/Login', [
      'canRegister' => Route::has('register'),
      'canResetPassword' => Route::has('password.request'),
      'status' => session('status'),
    ]);
  }
```

- resources\js\Pages\Auth\Login.vue

```js
defineProps<{
  canRegister: Boolean,
  canResetPassword?: boolean;
  status?: string;
}>();

      <div class="flex items-center justify-end mt-4 space-x-6">
        <Link v-if="canRegister" :href="route('register')"
          class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
        Not registered jet?
        </Link>
```

```bash
npm install && npm run dev
```

```bash
php artisan serve
```

```bash
git add . && git commit -am "v0014"
git push
```

```bash
git clone https://github.com/ZdravekSprite/vanilla2.git
npm install
composer update
php artisan migrate
```
