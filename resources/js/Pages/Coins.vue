<script setup lang="ts">
import Page from '@/Components/Page.vue';

interface Coin {
  id: number;
  coin: string;
  depositAllEnable: boolean;
  withdrawAllEnable: boolean;
  name: string;
  free: number;
  locked: number;
  freeze: number;
  withdrawing: number;
  ipoing: number;
  ipoable: number;
  storage: number;
  isLegalMoney: boolean;
  trading: boolean;
}

interface Label {
  id: number;
  name: string;
}

const props = defineProps<{
  all: number;
  coins: {
    data: Array<Coin>;
    links: Array<object>
  };
}>();
</script>

<template>
  <Page :all="all" single="coin" plural="coins" :elements="coins"
    :labels_all="[['coin'], ['name']]"
    :labels_show="[['coin'], ['name']]" />
</template>
