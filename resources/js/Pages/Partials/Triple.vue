<script setup>
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import Btn from '@/Components/Btn.vue';
import Box from '@/Components/Box.vue';

const props = defineProps({
  euros: Array
});

const triple = (n) => {
  let array = new Array;
  for (let i = 1; i < n - 1; i++) {
    for (let j = i + 1; j < n; j++) {
      for (let z = j + 1; z <= n; z++) {
        array.push([[i, j, z], 0])
      }
    }
  }
  return array;
};

let array = triple(50);

const confirmingTriple = ref(false);

const confirmTriple = () => {

  if (props.euros) props.euros.forEach(el => {
    array.forEach((c, no) => {
      if (c[0].every((d) => [el.no1, el.no2, el.no3, el.no4, el.no5].includes(d))) {
        array[no][1] += 1;
      }
    })
  });
  //console.log(array);
  confirmingTriple.value = true;
};

const closeModal = () => {
  confirmingTriple.value = false;
};
</script>

<template>
  <div>
    <Btn secondary @click="confirmTriple">
      Triple
    </Btn>

    <Modal :show="confirmingTriple" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Triple
        </h2>
        <div class="grid grid-cols-6 gap-3">
          <Box v-for="(e, i) in array" :key="i" :header="e[0]" :value="e[1]" :limit=0 />
        </div>
        <div class="mt-6 flex justify-end">
          <Btn secondary @click="closeModal">Cancel</Btn>
        </div>
      </div>
    </Modal>
  </div>
</template>