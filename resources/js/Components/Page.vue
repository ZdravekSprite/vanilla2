<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import FileForm from '@/Components/FileForm.vue';
import NewForm from '@/Components/NewForm.vue';
import EditForm from '@/Components/EditForm.vue';
import DeleteForm from '@/Components/DeleteForm.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps<{
  all: number,
  single: string,
  plural: string
  elements: {
    data?: Array<{
      id: number;
      date: Date;
    }>,
    links: Array<object>
  },
  labels_all: Array<Array<string | Array<{
    id: number;
    name: String;
  }>>>,
  labels_show: Array<Array<string | Array<{
    id: number;
    name: String;
  }>>>,
}>();

const isAuth = usePage().props.auth;
const isAdmin = isAuth ? usePage().props.auth.is_admin : false;
const title = props.plural ? props.plural.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') : '';
const t = props.plural ? props.plural.replace(/\b(\S)/g, (t) => { return t.toUpperCase() }) : '';

const dateFormat = (date: Date) => {
  let objectDate = new Date(date);
  let day = objectDate.getDate();
  let month = objectDate.getMonth() + 1;
  let year = objectDate.getFullYear();
  return day + '. ' + month + '. ' + year + '.'
}
</script>

<template>
  <Head :title="t" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden sm:-my-px sm:ml-10 sm:flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pr-4">{{ t }}</h2>
        <FileForm v-if="isAdmin" :fileName="plural + '.csv'" link="import" :model="single" title="Import" class="p-1" />
        <FileForm v-if="isAdmin" :fileName="plural + '.csv'" link="export" :model="single" title="Export" class="p-1" />
        <NewForm :storeRoute="single + '.store'" :labels="labels_all" class="p-1" />
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
            <table v-if="elements" class="table-auto w-full">
              <caption class="caption-top">
                Days!
              </caption>
              <thead class="text-lg font-medium text-gray-900 dark:text-gray-100">
                <tr>
                  <th v-for="(l, i) in labels_show" :key="i">{{ l[0] }}</th>
                  <th class="w-32">actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(e, i) in elements.data" :key="e.id">
                  <th v-for="(l, j) in labels_show" :key="j">
                    <span v-if="l[0] == 'date'">{{ dateFormat(e[l[0]]) }}</span>
                    <span v-else>{{ e[l[0]] }}</span>
                  </th>
                  <td>
                    <EditForm class="float-left" :element="e" :updateRoute="single + '.update'" :labels="labels_all" />
                    <DeleteForm class="float-right" :element="e" :destroyRoute="single + '.destroy'" />
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="8">
                    <Pagination v-if="elements" :links="elements.links" />
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