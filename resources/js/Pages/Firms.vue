<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FileForm from '@/Components/FileForm.vue';
import Pagination from '@/Components/Pagination.vue';
import NewForm from '@/Components/NewForm.vue';
import EditForm from '@/Components/EditForm.vue';
import DeleteForm from '@/Components/DeleteForm.vue';

const props = defineProps<{
  all: number;
  firms: {
    data: Array<{
      id: number;
      name: String;
    }>;
    links: Array<object>
  };
}>();
</script>

<template>
  <Head title="Firms" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden sm:-my-px sm:ml-10 sm:flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pr-4">Firms</h2>
        <FileForm fileName="firms.csv" link="import" model="firm" title="Import" class="p-1" />
        <FileForm fileName="firms.csv" link="export" model="firm" title="Export" class="p-1" />
        <NewForm :storeRoute="'firm.store'" :labels="[['name']]" class="p-1" />
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
            <table v-if="firms" class="table-auto w-full">
              <caption class="caption-top">
                Firms!
              </caption>
              <thead class="text-lg font-medium text-gray-900 dark:text-gray-100">
                <tr>
                  <th>name</th>
                  <th  class="w-32">actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(e, i) in firms.data" :key="e.id">
                  <td>{{ e['name'] }}</td>
                  <td>
                    <EditForm class="float-left" :element="e" updateRoute="firm.update" :labels="[['name']]" />
                    <DeleteForm class="float-right" :element="e" destroyRoute="firm.destroy" />
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="2">
                    <Pagination v-if="firms" :links="firms.links" />
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