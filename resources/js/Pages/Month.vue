<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DayList from './Partials/DayList.vue';
import Payroll1 from './Partials/Payroll1.vue';
import Payroll2 from './Partials/Payroll2.vue';
import EditForm from '@/Components/EditForm.vue';
import Btn from '@/Components/Btn.vue';
import { ref } from 'vue';
import MonthForm from './Partials/MonthForm.vue';

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
  next_night: string;
  holiday: string;
}
interface Firm {
  id: number;
  name: string;
  address: string;
  oib: string;
  iban: string;
  bank: string;
}
interface User {
  id: number;
  name: String;
  email: String;
  roles: Array<object>;
  isSuper: boolean;
}

const props = defineProps<{
  days: Array<Day>;
  firm: Firm;
  user: User;
  data: {
    valuta: string,
    bruto: number,
    minuli: number,
    odbitak: number,
    prirez: number,
    prijevoz: number,
    prehrana: number,
    stimulacija: number,
    nagrada: number,
    regres: number,
    bozicnica: number,
    prigodna: number,
    kredit: number,
    sindikat: number,
    first: string,
    last: string,
    h01: number,
    v01: number,
    h02: number,
    v02: number,
    h03: number,
    v03: number,
    h04: number,
    v04: number,
    h05: number,
    v05: number,
    h06: number,
    v06: number,
    h07: number,
    v07: number,
    h08: number,
    v08: number,
    h09: number,
    v09: number,
    h10: number,
    v10: number,
    h11: number,
    v11: number,
    h12: number,
    v12: number,
    h13: number,
    v13: number,
  };
  next: String;
  prev: String;
  next_id: number;
  prev_id: number;
}>();

const showPayroll = ref(true);
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
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pr-4">Month
          {{ new Date(props.data.first).getMonth() + 1 }}
          {{ new Date(props.data.first).getFullYear() }}</h2>
        <MonthForm class="float-left" :month="data" />
        <Btn @click="clickShowPayroll">{{ !showPayroll ? 'show' : 'hide' }} Payroll</Btn>
        <Btn @click="clickShowDayList">{{ !showDayList ? 'show' : 'hide' }} DayList</Btn>
      </div>
    </template>

    <div class="py-12 space-y-4">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div v-if="showPayroll" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-4 sm:p-8 text-gray-900 dark:text-gray-100">
            <Payroll1 v-if="firm.id == 1" :user="user" :firm="firm" :month="data" :next="next" :prev="prev" :next_id="next_id" :prev_id="prev_id" />
            <Payroll2 v-if="firm.id != 1" :user="user" :firm="firm" :month="data" :next="next" :prev="prev" :next_id="next_id" :prev_id="prev_id" />
          </div>
        </div>
        <div v-if="showDayList"
          class="bg-indigo-500 bg-indigo-400 bg-red-500 bg-green-500 bg-yellow-500 bg-yellow-400 bg-red-400 bg-indigo-100 bg-red-100 bg-green-100 bg-yellow-100 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <DayList v-if="days" :days="days" :next="next" :prev="prev" :next_id="next_id" :prev_id="prev_id" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
