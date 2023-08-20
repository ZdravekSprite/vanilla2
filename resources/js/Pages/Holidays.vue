<script setup lang="ts">
import Page from '@/Components/Page.vue';

interface Holiday {
  id: number;
  date: Date;
  name: string;
}

const props = defineProps<{
  all: number;
  holidays: {
    data: Array<Holiday>;
    links: Array<object>
  };
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
  <Page :all="all" single="holiday" plural="holidays" :elements="holidays"
    :labels_all="[['date'],['name']]"
    :labels_show="[['date'],['name']]" />
</template>
