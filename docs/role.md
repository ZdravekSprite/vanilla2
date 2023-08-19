# Role

```bash
php artisan make:model Role -a
php artisan make:middleware AccessAdmin
```

- database\migrations\2023_08_18_000001_create_roles_table.php

```php
  public function up(): void
  {
    Schema::create('roles', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->string('icon')->nullable();
      $table->string('description')->nullable();
      $table->timestamps();
    });
    Schema::create('role_user', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->foreignId('role_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->timestamps();
    });
  }
  public function down(): void
  {
    Schema::dropIfExists('roles');
    Schema::dropIfExists('role_user');
  }
```

- app\Http\Middleware\HandleInertiaRequests.php
- app\Http\Middleware\AccessAdmin.php
- routes\web.php
- app\Http\Kernel.php
- resources\js\types\index.d.ts
- resources\js\Layouts\AuthenticatedLayout.vue
