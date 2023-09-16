<script setup lang="ts">
import Page from '@/Components/Page.vue';

interface Label {
  id: number;
  name: string;
}

const props = defineProps<{
  all: number;
  months: {
    data: Array<{
      id: number;
      month: number;
      _year: number;
      firm: string;
      bruto: number;
      minuli: string,
      odbitak: string,
      prirez: string,
      prijevoz: string,
      prehrana: string,
      slug: String;
      user: String;
    }>;
    links: Array<object>
  };
  firms: Array<Label>;
}>();
//console.log(props.months.data);
</script>

<template>
  <Page :all="all" single="month" plural="months" :elements="months" :labels_all="[['_month'], ['_year'], ['firm', props.firms]]"
    :labels_show="[['slug'], ['user'], ['firm'], ['bruto'], ['minuli'], ['odbitak'], ['prirez'], ['prijevoz'], ['prehrana']]" />
</template>