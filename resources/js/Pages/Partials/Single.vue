<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import Btn from '@/Components/Btn.vue';
import Box from '@/Components/Box.vue';

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

const confirmingSingle = ref(false);

const confirmSingle = () => {
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
  //console.log(array, barray);
  confirmingSingle.value = true;
};

const closeModal = () => {
  confirmingSingle.value = false;
};
</script>

<template>
  <div>
    <Btn secondary @click="confirmSingle">
      Single
    </Btn>

    <Modal :show="confirmingSingle" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Single
        </h2>
        <Box v-for="(e, i) in array" :key="i" :header="i+1" :value="e" />
        <Box v-for="(e, j) in barray" :key="j" :header="j+1" :value="e" />
        <div class="mt-6 flex justify-end">
          <Btn secondary @click="closeModal">Cancel</Btn>
        </div>
      </div>
    </Modal>
  </div>
</template>