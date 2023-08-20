<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Btn from '@/Components/Btn.vue';

const props = defineProps({
  storeRoute: String,
  labels: Array,
});

const confirmingStore = ref(false);

const frmObj = {};
for (let i = 0; i < props.labels.length; i++) {
  if (props.labels[i][1] == 'check') {
    frmObj[props.labels[i][0]] = false;
  } else {
    frmObj[props.labels[i][0]] = props.labels[i].length > 1 && props.labels[i][1].length > 1 ? props.labels[i][1][0].id : "";
  }
}
const form = useForm(frmObj);

const confirmStore = () => {
  confirmingStore.value = true;
};

const create = () => {
  form.post(route(props.storeRoute), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => console.log('error'),
    onFinish: () => { form.reset(); form.clearErrors(); },
  });
};

const closeModal = () => {
  confirmingStore.value = false;
  form.reset();
};
</script>

<template>
  <div>
    <Btn secondary @click="confirmStore">New</Btn>

    <Modal :show="confirmingStore" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          New {{ props.storeRoute.split(".")[0].replace(/\b(\S)/g, (t) => { return t.toUpperCase() }) }}?
        </h2>
        <div v-for="l in labels" :key="l" class="mt-6">
          <InputLabel :for="l[0]" :value="l[0].replace(/\b(\S)/g, (t) => { return t.toUpperCase() })" />
          <template v-if="l.length == 1">
            <template v-if="['date', 'from', 'to', 'expiration'].includes(l[0])">
              <TextInput :id="l[0]" v-model="form[l[0]]" type="date" class="mt-1 block w-3/4" :placeholder="l[0]" />
            </template>
            <template v-else-if="['state'].includes(l[0])">
              <TextInput :id="l[0]" v-model="form[l[0]]" type="number" class="mt-1 block w-3/4" :placeholder="l[0]" />
            </template>
            <template v-else-if="['_month'].includes(l[0])">
              <select id="month" name="month" v-model="form[l[0]]"
                class="block mt-1 w-full rounded-md shadow-sm dark:bg-gray-900 dark:text-gray-300 border-gray-300 dark:border-gray-700 focus:border-indigo-300 dark:focus:border-indigo-600 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600 focus:ring-opacity-50">
                <option v-for="m in [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]" :key="m" :value="m">{{ m }}</option>
              </select>
            </template>
            <template v-else-if="['_year'].includes(l[0])">
              <select id="year" name="year" v-model="form[l[0]]"
                class="block mt-1 w-full rounded-md shadow-sm dark:bg-gray-900 dark:text-gray-300 border-gray-300 dark:border-gray-700 focus:border-indigo-300 dark:focus:border-indigo-600 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600 focus:ring-opacity-50">
                <option v-for="y in [2019, 2020, 2021, 2023, 2024, 2025]" :key="y" :value="y">{{ y }}</option>
              </select>
            </template>
            <template v-else>
              <TextInput :id="l[0]" v-model="form[l[0]]" type="text" class="mt-1 block w-3/4" :placeholder="l[0]" />
            </template>
          </template>
          <template v-else-if="l[1] == 'check'">
            <Checkbox :name="l[0]" v-model:checked="form[l[0]]" />
          </template>
          <template v-else>
            <select
              class="mt-1 block w-3/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
              :name="l[0]" :id="l[0]" v-model="form[l[0]]">
              <option v-for="o in l[1]" :value="o.id">{{ o.name }}</option>
            </select>
          </template>
          <InputError :message="form.errors[l[0]]" class="mt-2" />
        </div>
        <div class="mt-6 flex justify-end">
          <Btn secondary @click="closeModal">Cancel</Btn>
          <Btn primary class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="create">Create</Btn>
        </div>
      </div>
    </Modal>
  </div>
</template>