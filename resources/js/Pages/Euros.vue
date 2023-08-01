<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ImportForm from '@/Components/ImportForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';

defineProps<{
  euros?: Array<any>;
}>();

const range = () =>
  Array(Math.ceil(50)).fill(1).map((x, y) => x + y);

const shuffleArray = (array:Array<number>) => {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    const temp = array[i];
    array[i] = array[j];
    array[j] = temp;
  }
  return array;
}

const rndNo = (no:number) => {
  return Math.ceil(Math.random() * no);
};

let rnd1 = rndNo(50);
let rnd2 = rndNo(50);
let rnd3 = rndNo(50);
let rnd4 = rndNo(50);
let rnd5 = rndNo(50);

const rndCalc = () => {
  let array = shuffleArray(range());
  const n1 = array.pop();
  array = shuffleArray(array);
  const n2 = array.pop();
  array = shuffleArray(array);
  const n3 = array.pop();
  array = shuffleArray(array);
  const n4 = array.pop();
  array = shuffleArray(array);
  const n5 = array.pop();
  console.log(n1,n2,n3,n4,n5,array)
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
          <div class="p-6 text-gray-900 dark:text-gray-100">{{ rnd1 }} {{ rnd2 }} {{ rnd3 }} {{ rnd4 }} {{ rnd5 }}</div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
