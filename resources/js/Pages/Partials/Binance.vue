<script setup lang="ts">
import Btn from '@/Components/Btn.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
  binance: number | Array<Object> | Object;
}>();

const formSELP = useForm({
  earn: 'SELP',
});

const updateSELP = () => {
  formSELP.post(route('earn.update'), {
    preserveScroll: true,
    onError: () => console.log('error'),
    onFinish: () => { formSELP.reset(); formSELP.clearErrors(); },
  });
};

const formSELL = useForm({
  earn: 'SELL',
});

const updateSELL = () => {
  formSELL.post(route('earn.update'), {
    preserveScroll: true,
    onError: () => console.log('error'),
    onFinish: () => { formSELL.reset(); formSELL.clearErrors(); },
  });
};

const formSEFP = useForm({
  earn: 'SEFP',
});

const updateSEFP = () => {
  formSEFP.post(route('earn.update'), {
    preserveScroll: true,
    onError: () => console.log('error'),
    onFinish: () => { formSEFP.reset(); formSEFP.clearErrors(); },
  });
};

const formSEFL = useForm({
  earn: 'SEFL',
});

const updateSEFL = () => {
  formSEFL.post(route('earn.update'), {
    preserveScroll: true,
    onError: () => console.log('error'),
    onFinish: () => { formSEFL.reset(); formSEFL.clearErrors(); },
  });
};
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Binance</h2>
      <Btn @click="updateSELP">update SELP</Btn>
      <Btn @click="updateSELL">update SELL</Btn>
      <Btn @click="updateSEFP">update SEFP</Btn>
      <Btn @click="updateSEFL">update SEFL</Btn>
    </header>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
          <p class="flex justify-between text-gray-900 dark:text-gray-100">
            {{ binance }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>
