<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DayList from './Partials/DayList.vue';
import Payroll from './Partials/Payroll.vue';
import EditForm from '@/Components/EditForm.vue';
import Btn from '@/Components/Btn.vue';
import { ref } from 'vue';

interface Day {
  id: number;
  date: Date;
  _date: string;
  user: string;
  user_id: number;
  firm: string;
  firm_id: number;
  state: number;
  night: string;
  start: string;
  end: string;
  holiday: string;
}

const props = defineProps<{
  month: Array<Day>;
  data: {
    bruto: string,
    minuli: string,
    odbitak: string,
    prirez: string,
    prijevoz: string,
    prehrana: string,
    stimulacija: string,
    nagrada: string,
    regres: string,
    bozicnica: string,
    prigodna: string,
    kredit: string,
    sindikat: string,
    first: string,
    last: string,
    h01: string,
    v01: string,
    h02: string,
    v02: string,
    h03: string,
    v03: string,
    h04: string,
    v04: string,
    h05: string,
    v05: string,
    h06: string,
    v06: string,
    h07: string,
    v07: string,
    h08: string,
    v08: string,
    h09: string,
    v09: string,
    h10: string,
    v10: string,
    h11: string,
    v11: string,
    h12: string,
    v12: string,
    h13: string,
    v13: string,
  };
  next: String;
  prev: String;
  next_id: number;
  prev_id: number;
}>();

const showPayroll = ref(false);
const clickShowPayroll = () => {
  showPayroll.value = !showPayroll.value;
};

const showDayList = ref(false);
const clickShowDayList = () => {
  showDayList.value = !showDayList.value;
};
</script>

<template>
  <Head title="Month" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden sm:-my-px sm:ml-10 sm:flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pr-4">Month</h2>
        <EditForm class="float-left" :element="data" updateRoute="month.update"
          :labels="[['bruto'], ['minuli'], ['odbitak'], ['prirez'], ['prijevoz'], ['prehrana'], ['stimulacija'], ['nagrada'], ['regres'], ['bozicnica'], ['prigodna'], ['kredit'], ['sindikat'], ['first'], ['last'], ['h01'], ['v01'], ['h02'], ['v02'], ['h03'], ['v03'], ['h04'], ['v04'], ['h05'], ['v05'], ['h06'], ['v06'], ['h07'], ['v07'], ['h08'], ['v08'], ['h09'], ['v09'], ['h10'], ['v10'], ['h11'], ['v11'], ['h12'], ['v12'], ['h13'], ['v13']]" />
        <Btn @click="clickShowPayroll">{{ !showPayroll ? 'show' : 'hide' }} Payroll</Btn>
        <Btn @click="clickShowDayList">{{ !showDayList ? 'show' : 'hide' }} DayList</Btn>
      </div>
    </template>

    <div class="py-12 space-y-4">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div v-if="showPayroll" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-4 sm:p-8 text-gray-900 dark:text-gray-100">
            <Payroll :month="data" :next="next" :prev="prev" :next_id="next_id" :prev_id="prev_id" />
          </div>
        </div>
        <div v-if="showDayList"
          class="bg-indigo-500 bg-indigo-400 bg-red-500 bg-green-500 bg-yellow-500 bg-yellow-400 bg-red-400 bg-indigo-100 bg-red-100 bg-green-100 bg-yellow-100 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <DayList v-if="month" :month="month" :next="next" :prev="prev" :next_id="next_id" :prev_id="prev_id" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
