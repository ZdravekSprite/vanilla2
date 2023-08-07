<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FileForm from '@/Components/FileForm.vue';
import Pagination from '@/Components/Pagination.vue';
import NewForm from '@/Components/NewForm.vue';

const props = defineProps<{
  all: number;
  holidays: {
    data: Array<{
      id: number;
      date: Date;
      name: String;
    }>;
    links: Array<object>
  };
}>();
</script>

<template>
  <Head title="Holidays" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden sm:-my-px sm:ml-10 sm:flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pr-4">Holidays</h2>
        <FileForm fileName="holidays.csv" link="import" model="holiday" title="Import" class="p-1" />
        <FileForm fileName="holidays.csv" link="export" model="holiday" title="Export" class="p-1" />
        <NewForm :storeRoute="'holiday.store'" :labels="[['date'], ['name']]" class="p-1" />
      </div>
    </template>

    <div class="py-12 space-y-4">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">All: {{ all }}</div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <table v-if="holidays" class="table-auto w-full">
              <caption class="caption-top">
                Holidays!
              </caption>
              <thead class="text-lg font-medium text-gray-900 dark:text-gray-100">
                <tr>
                  <th>date</th>
                  <th>name</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(e, i) in holidays.data" :key="e.id">
                  <td>{{ e['date'] }}</td>
                  <td>{{ e['name'] }}</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="8">
                    <Pagination v-if="holidays" :links="holidays.links" />
                  </th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
