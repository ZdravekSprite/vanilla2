<script setup lang="ts">
import Page from '@/Components/Page.vue';

interface Label {
  id: number;
  name: string;
}

const props = defineProps<{
  all: number;
  firms: {
    data: Array<Label>;
    links: Array<object>
  };
}>();
</script>

<template>
  <Page :all="all" single="firm" plural="firms" :elements="firms"
    :labels_all="[['name']]"
    :labels_show="[['name']]" />
</template>