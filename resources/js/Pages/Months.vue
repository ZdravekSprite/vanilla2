<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FileForm from '@/Components/FileForm.vue';
import Pagination from '@/Components/Pagination.vue';
import NewForm from '@/Components/NewForm.vue';
import EditForm from '@/Components/EditForm.vue';
import DeleteForm from '@/Components/DeleteForm.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
  all: number;
  months: {
    data: Array<{
      id: number;
      month: number;
      slug: String;
    }>;
    links: Array<object>
  };
}>();
//console.log(props.months.data);
</script>

<template>
  <Head title="Months" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden sm:-my-px sm:ml-10 sm:flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pr-4">Months</h2>
        <FileForm fileName="months.csv" link="import" model="month" title="Import" class="p-1" />
        <FileForm fileName="months.csv" link="export" model="month" title="Export" class="p-1" />
        <NewForm :storeRoute="'month.store'" :labels="[['month'], ['year']]" class="p-1" />
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
            <table v-if="months" class="table-auto w-full">
              <caption class="caption-top">
                Months!
              </caption>
              <thead class="text-lg font-medium text-gray-900 dark:text-gray-100">
                <tr>
                  <th>month</th>
                  <th class="w-32">actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(e, i) in months.data" :key="e.id">
                  <td><Link :href="route('month', e.id)">{{ e['slug'] }}</Link></td>
                  <td>
                    <EditForm class="float-left" :element="e" updateRoute="month.update" :labels="[['month']]" />
                    <DeleteForm class="float-right" :element="e" destroyRoute="month.destroy" />
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="3">
                    <Pagination v-if="months" :links="months.links" />
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
