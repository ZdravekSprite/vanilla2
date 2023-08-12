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
  days: {
    data: Array<{
      id: number;
      date: Date;
      user_id: number;
      firm_id: number;
      state: number;
      night: String;
      start: String;
      end: String;
    }>;
    links: Array<object>
  };
  firms: Array<{
    id: number;
    name: String;
  }>;
}>();

const dateFormat = (date: Date) => {
  let objectDate = new Date(date);
  let day = objectDate.getDate();
  let month = objectDate.getMonth() + 1;
  let year = objectDate.getFullYear();
  return day + '. ' + month + '. ' + year + '.'
}
</script>

<template>
  <Head title="Days" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden sm:-my-px sm:ml-10 sm:flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pr-4">Days</h2>
        <FileForm fileName="days.csv" link="import" model="day" title="Import" class="p-1" />
        <FileForm fileName="days.csv" link="export" model="day" title="Export" class="p-1" />
        <NewForm :storeRoute="'day.store'"
          :labels="[['date'], ['user_id'], ['firm', props.firms], ['state'], ['night'], ['start'], ['end']]" class="p-1" />
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
            <table v-if="days" class="table-auto w-full">
              <caption class="caption-top">
                Days!
              </caption>
              <thead class="text-lg font-medium text-gray-900 dark:text-gray-100">
                <tr>
                  <th>date</th>
                  <td>user_id</td>
                  <td>firm</td>
                  <td>state</td>
                  <td>night</td>
                  <td>start</td>
                  <td>end</td>
                  <th>actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(e, i) in days.data" :key="e.id">
                  <td>{{ dateFormat(e['date']) }}</td>
                  <td>{{ e['user_id'] }}</td>
                  <td>{{ props.firms.find(x => x.id === e.firm_id) ? props.firms.find(x => x.id === e.firm_id).name : '' }}</td>
                  <td>{{ e['state'] }}</td>
                  <td>{{ e['night'] }}</td>
                  <td>{{ e['start'] }}</td>
                  <td>{{ e['end'] }}</td>
                  <td>
                    <EditForm class="float-left" :element="e" updateRoute="day.update" :labels="[['date'], ['name']]" />
                    <DeleteForm class="float-right" :element="e" destroyRoute="day.destroy" />
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="3">
                    <Pagination v-if="days" :links="days.links" />
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
