<script setup>
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import Btn from '@/Components/Btn.vue';
import Box from '@/Components/Box.vue';

const props = defineProps({
  euros: Array
});

const range = (n) => Array(Math.ceil(n)).fill(0);
const double = (n) => {
  let array = new Array;
  for (let i = 1; i < n; i++) {
    for (let j = i + 1; j <= n; j++) {
      array.push([[i, j], 0])
    }
  }
  return array;
};


let array = double(50);
let barray = double(12);

const confirmingDouble = ref(false);

const confirmDouble = () => {
  
  if (props.euros) props.euros.forEach(el => {
    array.forEach((c, no) => {
      if (c[0].every((d) => [el.no1, el.no2, el.no3, el.no4, el.no5].includes(d))) {
        array[no][1] += 1;
      }
    })
    barray.forEach((c, bno) => {
      if (c[0].every((d) => [el.bn1, el.bn2].includes(d))) {
        barray[bno][1] += 1;
      }
    })
  });
  //console.log(array, barray);
  let count0 = array.filter((x,y) => x[1] <= 10).length
  let count1 = array.filter((x,y) => x[1] > 10).length
  console.log(count0,count1)
  confirmingDouble.value = true;
};

const closeModal = () => {
  confirmingDouble.value = false;
};
</script>

<template>
  <div>
    <Btn secondary @click="confirmDouble">
      Double
    </Btn>

    <Modal :show="confirmingDouble" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Double
        </h2>
        <div class="grid grid-cols-6 gap-3">
          <Box v-for="(e, i) in array" :key="i" :header="e[0]" :value="e[1]" :limit=1 />
        </div>
        <div class="grid grid-cols-5 gap-4">
          <Box v-for="(e, j) in barray" :key="j" :header="e[0]" :value="e[1]" :limit=1 />
        </div>
        <div class="mt-6 flex justify-end">
          <Btn secondary @click="closeModal">Cancel</Btn>
        </div>
      </div>
    </Modal>
  </div>
</template>