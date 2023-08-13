<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import EditForm from '@/Components/EditForm.vue';

const props = defineProps<{
  month: Array<{
    id: number;
    date: Date;
    user: String;
    user_id: number;
    firm: String;
    firm_id: number;
    state: number;
    night: String;
    start: String;
    end: String;
    holiday: String;
  }>;
}>();

const dateFormat = (date: Date) => {
  let objectDate = new Date(date);
  let day = objectDate.getDate();
  let month = objectDate.getMonth() + 1;
  let year = objectDate.getFullYear();
  return day + '. ' + month + '. ' + year + '.'
}

const bgColor = (state: number, date: Date) => {
  let objectDate = new Date(date);
  let day = objectDate.getDay();
  let bgColor = '-' + (day > 0 ? '100' : '400');
  switch (state) {
    case 4:
      bgColor = 'bg-red' + bgColor;
      break;
    case 3:
      bgColor = 'bg-gray' + bgColor;
      break;
    case 2:
      bgColor = 'bg-green' + bgColor;
      break;
    case 1:
      bgColor = 'bg-indigo' + bgColor;
      break;
    default:
      bgColor = 'bg-yellow' + bgColor;
  }
  return bgColor
}

const bgColorBar = (state: number) => {
  let bgColor = '-500';
  switch (state) {
    case 4:
      bgColor = 'bg-red' + bgColor;
      break;
    case 3:
      bgColor = 'bg-gray' + bgColor;
      break;
    case 2:
      bgColor = 'bg-green' + bgColor;
      break;
    case 1:
      bgColor = 'bg-indigo' + bgColor;
      break;
    default:
      bgColor = 'bg-yellow' + bgColor;
  }
  return bgColor
}

const barWidth = (start: String = '00:00', end: String = '00:00') => {
  var a = start.split(':');
  var b = end.split(':');
  var startm = (+a[0]) * 60 + (+a[1]);
  var endm = (+b[0]) * 60 + (+b[1]);
  //console.log(start,end,startm,endm);
  let barWidth = (endm - startm)/1440*100+'%';
  return barWidth
}
//console.log(props.month);
</script>

<template>
  <Head title="Month" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden sm:-my-px sm:ml-10 sm:flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pr-4">Month</h2>
      </div>
    </template>

    <div class="py-12 space-y-4">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-indigo-500 bg-indigo-400 bg-red-500 bg-green-500 bg-yellow-500 bg-yellow-400 bg-indigo-100 bg-red-100 bg-green-100 bg-yellow-100 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <table v-if="month" class="table-auto w-full">
              <caption class="caption-top">
                Month!
              </caption>
              <thead class="text-lg font-medium text-gray-900 dark:text-gray-100">
                <tr>
                  <th class="w-32">day</th>
                  <th></th>
                  <th class="w-32">actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(e, i) in month" :key="e.id">
                  <td :class="{ 'text-red-400': e['holiday'] }">{{ dateFormat(e['date']) }}</td>
                  <td>
                    <div :title="dateFormat(e['date'])" class="w-full rounded-md relative"
                      :class="bgColor(e['state'], e['date'])" style="min-height: 18px;">
                      <template v-if="e['state'] == 1">
                        <div class="absolute rounded-l-md min-h-full" :class="bgColorBar(e['state'])" :style="{ width: barWidth('00:00',e['night']) }"></div>
                        <div class="absolute min-h-full" :class="bgColorBar(e['state'])" :style="{ 'margin-left': barWidth('00:00',e['start']), width: barWidth(e['start'],e['end']) }"></div>
                      </template>
                      <template v-else>
                        <div class="absolute rounded-l-md min-h-full" :class="bgColorBar(e['state'])" :style="{ width: barWidth('00:00',e['night']) }"></div>
                      </template>
                    </div>
                  </td>
                  <td>
                    <EditForm class="float-left" :element="e" updateRoute="day.update" :labels="[['date']]" />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
