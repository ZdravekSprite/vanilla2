<script setup lang="ts">
import Page from '@/Components/Page.vue';

interface Symbol {
  id: number;
  symbol: string;
  status: string;
}

interface Label {
  id: number;
  name: string;
}

const props = defineProps<{
  all: number;
  symbols: {
    data: Array<Symbol>;
    links: Array<object>
  };
}>();
</script>

<template>
  <Page :all="all" single="symbol" plural="symbols" :elements="symbols"
    :labels_all="[['symbol'], ['status']]"
    :labels_show="[['symbol'], ['status']]" />
</template>
