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

const shuffleArray = () => {
  let array = range();
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    const temp = array[i];
    array[i] = array[j];
    array[j] = temp;
  }
  return array;
}

const rndNo = () => {
  return Math.ceil(Math.random() * 50);
};

let rnd1 = rndNo();
let rnd2 = rndNo();
let rnd3 = rndNo();
let rnd4 = rndNo();
let rnd5 = rndNo();

const rndCalc = () => {
  rnd1 = rndNo();
  rnd2 = rndNo();
  rnd3 = rndNo();
  rnd4 = rndNo();
  rnd5 = rndNo();
  console.log(rnd1, rnd2, rnd3, rnd4, rnd5, range(), shuffleArray())
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
