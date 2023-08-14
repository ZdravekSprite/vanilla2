<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
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
  next: String;
  prev: String;
  next_id: number;
  prev_id: number;
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
  let barWidth = (endm - startm) / 1440 * 100 + '%';
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
        <div
          class="bg-indigo-500 bg-indigo-400 bg-red-500 bg-green-500 bg-yellow-500 bg-yellow-400 bg-red-400 bg-indigo-100 bg-red-100 bg-green-100 bg-yellow-100 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <table v-if="month" class="table-auto w-full">
              <caption class="caption-top">
                <div class="flex justify-between">
                  <div>
                    <Link :href="route('month', prev_id)" :title="prev">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                    class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                      d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                  </svg>
                  </Link>
                  </div>
                  <div>
                    Month!
                  </div>
                  <div>
                    <Link :href="route('month', next_id)" :title="next">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                    class="bi bi-arrow-right-square" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                      d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 5.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                  </svg>
                  </Link>
                  </div>
                </div>
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
                      <div v-if="e['night'] != '00:00'" class="absolute rounded-l-md min-h-full"
                        :class="bgColorBar(e['state'])" :style="{ width: barWidth('00:00', e['night']) }"></div>
                      <div v-if="e['state'] == 1" class="absolute min-h-full" :class="bgColorBar(e['state'])"
                        :style="{ 'margin-left': barWidth('00:00', e['start']), width: barWidth(e['start'], e['end']) }">
                      </div>
                      <template v-else>
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