<script setup lang="ts">
import Page from '@/Components/Page.vue';

interface Earn {
  id: number;
  earn: string;
  user_id: number;
  positionId: number;
  productId: string;
  asset: string;
  amount: string;
  purchaseTime: number;
  duration: number;
  accrualDays: number;
  rewardAsset: string;
  rewardAmt: string;
  nextPay: string;
  nextPayDate: number;
  payPeriod: number;
  redeemAmountEarly: string;
  rewardsEndDate: number;
  deliverDate: number;
  redeemPeriod: number;
  canRedeemEarly: boolean;
  autoSubscribe: boolean;
  type: string;
  status: string;
  canReStake: boolean;
  apy: string;
}

interface Label {
  id: number;
  name: string;
}

const props = defineProps<{
  all: number;
  earns: {
    data: Array<Earn>;
    links: Array<object>
  };
}>();
</script>

<template>
  <Page :all="all" single="earn" plural="earns" :elements="earns" :labels_all="[['earn'], ['asset'], ['amount']]"
    :labels_show="[['earn'], ['asset'], ['amount']]" />
</template>
