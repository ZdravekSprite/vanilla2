<script setup lang="ts">
import Page from '@/Components/Page.vue';

const props = defineProps<{
  all: number;
  months: {
    data: Array<{
      id: number;
      month: number;
      _year: number;
      bruto: number;
      slug: String;
      user: String;
    }>;
    links: Array<object>
  };
}>();
//console.log(props.months.data);
</script>

<template>
  <Page :all="all" single="month" plural="months" :elements="months" :labels_all="[['_month'], ['_year']]"
    :labels_show="[['slug'], ['user'], ['bruto']]" />
</template>