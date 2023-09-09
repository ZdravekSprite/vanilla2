<script setup lang="ts">
import Page from '@/Components/Page.vue';

interface Firm {
  id: number;
  name: string;
  address: string;
  oib: string;
  iban: string;
  bank: string;
}

const props = defineProps<{
  all: number;
  firms: {
    data: Array<Firm>;
    links: Array<object>
  };
}>();
</script>

<template>
  <Page :all="all" single="firm" plural="firms" :elements="firms"
    :labels_all="[['name'], ['address'], ['oib'], ['iban'], ['bank']]"
    :labels_show="[['name'], ['address'], ['oib'], ['iban'], ['bank']]" />
</template>