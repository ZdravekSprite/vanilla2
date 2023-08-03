<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ImportForm from '@/Components/ImportForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';

const props = defineProps<{
  euros?: Array<any>;
}>();

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

const rndNo = (no: number) => {
  return Math.ceil(Math.random() * no);
};

let rnd = [rndNo(50), rndNo(50), rndNo(50), rndNo(50), rndNo(50)].sort(function (a: number, b: number) { return a - b });

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
  //const n = [2, 9, 38, 40, 44];
  const n = setNArr();
  const b = setBArr();
  const tSet = setTArr(n);
  let log = 'test';
  for (let index = 0; index < tSet.length; index++) {
    const test = tSet[index];
    log = log + (index + 1);
    if (props.euros) {
      for (let i = 0; i < props.euros.length; i++) {
        const element = props.euros[i];
        const haystack = [element.no1, element.no2, element.no3, element.no4, element.no5];
        if (test.every((v: any) => haystack.includes(v))) {
          console.log(log, n, test, haystack);
          return false;
        }
      }
    }
  }
  console.log(n,b)
  return n;
};

const rndCalc = () => {
  let test = rndTest();
  while (!test) {
    test = rndTest();
    if (test && test[0] < 10) test = false;
    if (test && test[4] > 39) test = false;
    /*
    if (test && test[0] != last[0]) test = false;
    if (test && test[1] != last[1]) test = false;
    if (test && test[2] != last[2]) test = false;
    if (test && test[3] != last[3]) test = false;
    if (test && test[4] != last[4]) test = false;
    */
  }
};

</script>

<template>
  <Head title="EuroJackPot" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">EuroJackPot</h2>
      <ImportForm fileName="euros.csv" link="euros.import" class="p-1" />
      <SecondaryButton @click="rndCalc"> Calc </SecondaryButton>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">EuroJackPot! {{ euros ? euros.length : 0 }}</div>
          <div class="p-6 text-gray-900 dark:text-gray-100">{{ rnd[0] }} {{ rnd[1] }} {{ rnd[2] }} {{ rnd[3] }} {{ rnd[4]
          }}</div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
