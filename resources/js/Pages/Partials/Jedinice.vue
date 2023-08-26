<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import { computed, ref } from 'vue';
import Btn from '@/Components/Btn.vue';
const props = defineProps({
  euros: Array<{
    no1: number;
    no2: number;
    no3: number;
    no4: number;
    no5: number;
    bn1: number;
    bn2: number;
  }>
});

const range = (n: number) => Array(Math.ceil(n)).fill(0);

let array = range(50);
let barray = range(12);

//const user = computed(() => '');

const confirmingJedinice = ref(false);

const confirmJedinice = () => {
  if (props.euros) props.euros.forEach(el => {
    array.forEach((c,no) => {
      if ([el.no1, el.no2, el.no3, el.no4, el.no5].includes(no+1)) {
        array[no] += 1;
      }
    })
    barray.forEach((c,bno) => {
      if ([el.bn1, el.bn2].includes(bno+1)) {
        barray[bno] += 1;
      }
    })
  });
  console.log(array, barray);
  confirmingJedinice.value = true;
};

const closeModal = () => {
  confirmingJedinice.value = false;
};
</script>

<template>
  <div>
    <Btn secondary @click="confirmJedinice">
      Jedinice
    </Btn>

    <Modal :show="confirmingJedinice" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Jedinice
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        <div v-for="(e, i) in array" :key="i">
          {{ i + 1 }} {{ e }}
        </div>
        </p>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        <div v-for="(e, i) in barray" :key="i">
          {{ i + 1 }} {{ e }}
        </div>
        </p>
        <div class="mt-6 flex justify-end">
          <Btn secondary @click="closeModal">Cancel</Btn>
        </div>
      </div>
    </Modal>
  </div>
</template>