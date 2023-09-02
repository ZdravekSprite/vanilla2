<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import FileForm from '@/Components/FileForm.vue';
import NewForm from '@/Components/NewForm.vue';
import EditForm from '@/Components/EditForm.vue';
import DeleteForm from '@/Components/DeleteForm.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
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

const title = props.plural ? props.plural.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ') : '';

const dateFormat = (d) => {
  let objectDate = new Date(d);
  let day = objectDate.getDate();
  let month = objectDate.getMonth() + 1;
  let year = objectDate.getFullYear();
  return day + '. ' + month + '. ' + year + '.'
}
//console.log(props.elements.data,props.labels_show);
</script>

<template>
  <table v-if="elements" class="table-auto w-full">
    <caption class="caption-top">{{title}}!</caption>
    <thead class="text-lg font-medium text-gray-900 dark:text-gray-100">
      <tr>
        <th v-for="(l, i) in labels_show" :key="i">{{ l[0] }}</th>
        <th class="w-36">actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="e in elements.data" :key="e.id">
        <td v-for="(l, j) in labels_show" :key="j">
          <span v-if="l[0] == 'date'">{{ dateFormat(e['date']) }}</span>
          <span v-else-if="l[0] == 'slug'">
            <Link :href="route('month', e.id)">{{ e['slug'] }}</Link>
          </span>
          <span v-else-if="['bruto', 'odbitak', 'prijevoz', 'prehrana'].includes(l[0])">{{ e[l[0]] / 100 + (e['_year'] > 2022
            ? ' €' : ' kn') }}</span>
          <span v-else-if="['minuli', 'prirez'].includes(l[0])">{{ e[l[0]] / 100 + ' %' }}</span>
          <span v-else>{{ e[l[0]] }}</span>
        </td>
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
</template>