<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Artisan from './Partials/Artisan.vue';
import { computed } from 'vue'
import { Head, usePage } from '@inertiajs/vue3';
import Binance from './Partials/Binance.vue';

const props = defineProps<{
  binance?: Array<Object>;
}>();

const user = computed(() => usePage().props.auth.user)
const isAdmin = usePage().props.auth.is_admin;
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">You're logged in as: {{ user.name }}!</div>
        </div>

        <div v-if="binance" class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <Binance :binance="binance"/>
        </div>

        <div v-if="isAdmin" class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <Artisan class="max-w-xl" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
