<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DayList from './Partials/DayList.vue';
import Payroll from './Partials/Payroll.vue';

const props = defineProps<{
  month: Array<{
    id: number;
    date: Date;
    user: String;
    user_id: number;
    firm: String;
    firm_id: number;
    state: number;
    night: String;
    start: String;
    end: String;
    holiday: String;
  }>;
  next: String;
  prev: String;
  next_id: number;
  prev_id: number;
}>();
</script>

<template>
  <Head title="Month" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden sm:-my-px sm:ml-10 sm:flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pr-4">Month</h2>
      </div>
    </template>

    <div class="py-12 space-y-4">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div
          class="bg-indigo-500 bg-indigo-400 bg-red-500 bg-green-500 bg-yellow-500 bg-yellow-400 bg-red-400 bg-indigo-100 bg-red-100 bg-green-100 bg-yellow-100 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <DayList v-if="month" :month="month" :next="next" :prev="prev" :next_id="next_id" :prev_id="prev_id" />
          </div>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-4 sm:p-8 text-gray-900 dark:text-gray-100">
              <Payroll :next="next" :prev="prev" :next_id="next_id" :prev_id="prev_id" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
