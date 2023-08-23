<script setup lang="ts">
const props = defineProps<{
  binance: Array<Object>;
}>();
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Binance</h2>
    </header>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
          <p class="flex justify-between text-gray-900 dark:text-gray-100">
            {{ binance }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>
