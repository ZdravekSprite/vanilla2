<script setup lang="ts">
import Page from '@/Components/Page.vue';

interface Label {
  id: number;
  name: string;
}

const props = defineProps<{
  all: number;
  months: {
    data: Array<object>;
    links: Array<object>
  };
  firms: Array<Label>;
}>();
//console.log(props.months.data);
</script>

<template>
  <Page :all="all" single="month" plural="months" :elements="months"
    :labels_all="[['_month'], ['_year'], ['firm', props.firms], ['first'], ['last']]"
    :labels_show="[['slug'], ['user'], ['firm'], ['bruto'], ['minuli'], ['odbitak'], ['prirez'], ['prijevoz'], ['prehrana']]" />
</template>