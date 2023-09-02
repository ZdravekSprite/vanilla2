<script setup lang="ts">
import PageTable from '@/Components/PageTable.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import Btn from '@/Components/Btn.vue';

interface EarnFP {
  id: number;
  user_id: number;
  productId: string;
  totalAmount: string;
  tierAnnualPercentageRate: string;
  latestAnnualPercentageRate: string;
  coin_id: number;
  canRedeem: boolean;
  collateralAmount: string;
  yesterdayRealTimeRewards: string;
  cumulativeBonusRewards: string;
  cumulativeRealTimeRewards: string;
  cumulativeTotalRewards: string;
  autoSubscribe: boolean;
}
interface EarnFL {
}
interface EarnLP {
  id: number;
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
interface EarnLL {
  id: number;
  user_id: number;
  projectId: string;
  asset: string;
  rewardAsset: string;
  duration: number;
  renewable: boolean;
  isSoldOut: boolean;
  apr: string;
  status: string;
  subscriptionStartTime: number;
  totalPersonalQuota: string;
  minimum: string;
}
interface Label {
  id: number;
  name: string;
}

const props = defineProps<{
  all: number;
  earn_f_p_s: {
    data: Array<EarnFP>;
    links: Array<object>
  };
  earn_f_l_s: {
    data: Array<EarnFL>;
    links: Array<object>
  };
  earn_l_p_s: {
    data: Array<EarnLP>;
    links: Array<object>
  };
  earn_l_l_s: {
    data: Array<EarnLL>;
    links: Array<object>
  };
}>();

const showSELP = ref(true);
const showSELL = ref(false);
const showSEFP = ref(true);
const showSEFL = ref(false);

const clickShowSELP = () => {
  showSELP.value = !showSELP.value;
};
const clickShowSELL = () => {
  showSELL.value = !showSELL.value;
};
const clickShowSEFP = () => {
  showSEFP.value = !showSEFP.value;
};
const clickShowSEFL = () => {
  showSEFL.value = !showSEFL.value;
};

</script>

<template>
  <Head title="Earns" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden sm:-my-px sm:ml-10 sm:flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pr-4">Earns</h2>
      </div>
    </template>
    <div class="py-12 space-y-4">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">All: {{ all }}</div>
          <Btn @click="clickShowSELP">{{ !showSELP ? 'show' : 'hide' }} SELP</Btn>
          <Btn @click="clickShowSELL">{{ !showSELL ? 'show' : 'hide' }} SELL</Btn>
          <Btn @click="clickShowSEFP">{{ !showSEFP ? 'show' : 'hide' }} SEFP</Btn>
          <Btn @click="clickShowSEFL">{{ !showSEFL ? 'show' : 'hide' }} SEFL</Btn>
        </div>
      </div>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
            <PageTable v-if="showSELP" :all="all" single="earn" plural="earns" :elements="earn_l_p_s"
              :labels_all="[['productId'],['asset'], ['amount']]" :labels_show="[['productId'],['asset'], ['amount'],['accrualDays'],['apy']]" />
            <PageTable v-if="showSELL" :all="all" single="earn" plural="earns" :elements="earn_l_l_s"
              :labels_all="[['projectId'], ['apr']]"
              :labels_show="[['projectId'], ['apr']]" />
            <PageTable v-if="showSEFP" :all="all" single="earn" plural="earns" :elements="earn_f_p_s"
              :labels_all="[['asset'], ['amount']]" :labels_show="[['asset'], ['totalAmount'],['latestAnnualPercentageRate']]" />
            <PageTable v-if="showSEFL" :all="all" single="earn" plural="earns" :elements="earn_f_l_s"
              :labels_all="[['asset'], ['latestAnnualPercentageRate']]"
              :labels_show="[['asset'], ['latestAnnualPercentageRate']]" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
