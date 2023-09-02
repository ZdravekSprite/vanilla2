<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import FileForm from '@/Components/FileForm.vue';
import NewForm from '@/Components/NewForm.vue';
import PageTable from './PageTable.vue';

const props = defineProps ({
  all: Number,
  single: String,
  plural: String,
  elements: {
    data: Array,
    links: Array,
  },
  labels_all: Array,
  labels_show: Array,
});

const isAuth = usePage().props.auth;
const isAdmin = isAuth ? usePage().props.auth.is_admin : false;
const t = props.plural ? props.plural.replace(/\b(\S)/g, (t) => { return t.toUpperCase() }) : '';

//console.log(props.elements.data,props.labels_show);
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
            <PageTable :all="all" :single="single" :plural="plural" :elements="elements" :labels_all="labels_all" :labels_show="labels_show" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>