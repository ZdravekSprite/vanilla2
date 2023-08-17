<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FileForm from '@/Components/FileForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps<{
  all: number;
  alleuros: Array<{
    no1: number;
    no2: number;
    no3: number;
    no4: number;
    no5: number;
    bn1: number;
    bn2: number;
  }>;
  euros: {
    data: Array<{
      id: number;
      time: Date;
      no1: number;
      no2: number;
      no3: number;
      no4: number;
      no5: number;
      bn1: number;
      bn2: number;
    }>;
    links: Array<object>;
  };
}>();

//console.log(props.euros);
const dateFormat = (date: Date) => {
  let objectDate = new Date(date);
  let day = objectDate.getDate();
  let month = objectDate.getMonth() + 1;
  let year = objectDate.getFullYear();
  let hour = objectDate.getHours();
  let minute = objectDate.getMinutes() > 9 ? objectDate.getMinutes() : '0' + objectDate.getMinutes();
  return day + '. ' + month + '. ' + year + '.' + ((hour || minute != '00') ? ' ' + hour + ':' + minute : '');
}

const range = (n: number) =>
  Array(Math.ceil(n)).fill(1).map((x, y) => x + y);

const shuffleArray = (array: Array<number>) => {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    const temp = array[i];
    array[i] = array[j];
    array[j] = temp;
  }
  return array;
}

const setNArr = () => {
  let array = shuffleArray(range(50));
  let n = new Array;
  n = [...n, array.pop()];
  array = shuffleArray(array);
  n = [...n, array.pop()];
  array = shuffleArray(array);
  n = [...n, array.pop()];
  array = shuffleArray(array);
  n = [...n, array.pop()];
  array = shuffleArray(array);
  n = [...n, array.pop()];
  n.sort(function (a: number, b: number) { return a - b });
  return n;
}

const setBArr = () => {
  let array = shuffleArray(range(12));
  let n = new Array;
  n = [...n, array.pop()];
  array = shuffleArray(array);
  n = [...n, array.pop()];
  n.sort(function (a: number, b: number) { return a - b });
  return n;
}

const setTArr = (nArr: Array<number>) => {
  let arr = new Array;
  arr = [...arr, [nArr[0], nArr[1], nArr[2]]];
  arr = [...arr, [nArr[0], nArr[1], nArr[3]]];
  arr = [...arr, [nArr[0], nArr[1], nArr[4]]];
  arr = [...arr, [nArr[0], nArr[2], nArr[3]]];
  arr = [...arr, [nArr[0], nArr[2], nArr[4]]];
  arr = [...arr, [nArr[0], nArr[3], nArr[4]]];
  arr = [...arr, [nArr[1], nArr[2], nArr[3]]];
  arr = [...arr, [nArr[1], nArr[2], nArr[4]]];
  arr = [...arr, [nArr[1], nArr[3], nArr[4]]];
  arr = [...arr, [nArr[2], nArr[3], nArr[4]]];
  return arr;
}

const rndTest = () => {
  const n = setNArr();
  const b = setBArr();
  if (b[1] - b[0] == 1) return false;
  const tSet = setTArr(n);
  let log = 'test';
  for (let index = 0; index < tSet.length; index++) {
    const test = tSet[index];
    log = log + (index + 1);
    if (props.alleuros) {
      for (let i = 0; i < props.alleuros.length; i++) {
        const element = props.alleuros[i];
        const haystack = [element.no1, element.no2, element.no3, element.no4, element.no5];
        if (test.every((v: any) => haystack.includes(v))) {
          //console.log(log, n, test, haystack);
          return false;
        }
      }
    }
  }
  console.log(log, n, b)
  return n;
};

const rndCalc = () => {
  let test = rndTest();
  while (!test) {
    test = rndTest();
    if (test && test[0] < 10) test = false;
    if (test && test[0] > 15) test = false;
    if (test && test[2] < 20 && test[2] > 29) test = false;
    if (test && test[4] > 39) test = false;
    if (test && test[4] < 34) test = false;
    if (test && test.some((v: any) => [13, 23, 34, 36, 37].includes(v))) test = false;
  }
};

</script>

<template>
  <Head title="EuroJackPot" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-flex pr-4">EuroJackPot</h2>
      <FileForm fileName="euros.csv" link="import" model="euro" title="Import" class="p-1 inline-flex" />
      <FileForm fileName="euros.csv" link="export" model="euro" title="Export" class="p-1 inline-flex" />
      <SecondaryButton @click="rndCalc"> Calc </SecondaryButton>
    </template>

    <div class="py-12 space-y-4">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">All: {{ all }}</div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <table v-if="euros" class="table-auto w-full">
              <caption class="caption-top">
                EuroJackPot!
              </caption>
              <thead class="text-lg font-medium text-gray-900 dark:text-gray-100">
                <tr>
                  <th>time</th>
                  <th>no1</th>
                  <th>no2</th>
                  <th>no3</th>
                  <th>no4</th>
                  <th>no5</th>
                  <th>bn1</th>
                  <th>bn2</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(e, i) in euros.data" :key="e.id">
                  <td>{{ dateFormat(e['time']) }}</td>
                  <td>{{ e['no1'] }}</td>
                  <td>{{ e['no2'] }}</td>
                  <td>{{ e['no3'] }}</td>
                  <td>{{ e['no4'] }}</td>
                  <td>{{ e['no5'] }}</td>
                  <td>{{ e['bn1'] }}</td>
                  <td>{{ e['bn2'] }}</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="8">
                    <Pagination v-if="euros" :links="euros.links" />
                  </th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
