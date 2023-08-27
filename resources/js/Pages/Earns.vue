<script setup lang="ts">
import PageTable from '@/Components/PageTable.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import FileForm from '@/Components/FileForm.vue';
import NewForm from '@/Components/NewForm.vue';

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
  earn: string;
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
  earn_l_p_s: {
    data: Array<EarnLP>;
    links: Array<object>
  };
  earn_l_l_s: {
    data: Array<EarnLL>;
    links: Array<object>
  };
}>();
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
        </div>
      </div>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
            <PageTable :all="all" single="earn" plural="earns" :elements="earn_l_p_s"
              :labels_all="[['asset'], ['amount']]" :labels_show="[['asset'], ['amount']]" />
            <PageTable :all="all" single="earn" plural="earns" :elements="earn_l_l_s"
              :labels_all="[['projectId'], ['apr']]" :labels_show="[['projectId'], ['apr']]" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
