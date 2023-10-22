<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import IconPen from '@/Components/IconPen.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Btn from '@/Components/Btn.vue';

const props = defineProps({
  element: Object,
  updateRoute: String,
  labels: Array,
});

const confirmingUpdate = ref(false);

const frmObj = {};
for (let i = 0; i < props.labels.length; i++) {
  if (props.labels[i].length == 1) {
    frmObj[props.labels[i]] = props.element[props.labels[i]] + '';
  } else if (props.labels[i][1] == 'check') {
    if (props.labels[i][2]) {
      let checked = [];
      for (let c of props.labels[i][2]) {
        checked[c.id] = {
          'id': c.id,
          'name': c.name,
          'checked': props.element[props.labels[i][0]].includes(c.name),
        };
      }
      frmObj[props.labels[i][0]] = checked;
    } else {
      frmObj[props.labels[i][0]] = props.element[props.labels[i][0]] > 0;
    }
  } else {
    frmObj[props.labels[i][0]] = props.element[props.labels[i][0] + '_id'];
  }
}
frmObj['id'] = props.element['id'];
const form = useForm(frmObj);
//console.log(frmObj,form);

const confirmUpdate = () => {
  confirmingUpdate.value = true;
};

const update = () => {
  form.patch(route(props.updateRoute, props.element.id), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => console.log('error'),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingUpdate.value = false;
  form.reset();
  form.clearErrors();
};
</script>

<template>
  <div>
    <Btn secondary @click="confirmUpdate">
      <IconPen class="block h-4 w-auto fill-current" />
    </Btn>

    <Modal :show="confirmingUpdate" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Edit {{ props.element.name ?? props.element.id + '. element' }}?
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
                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option v-for="m in [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]" :selected="l[0] === m" :key="m" :value="m">{{
                  m }}</option>
              </select>
            </template>
            <template v-else-if="['_year'].includes(l[0])">
              <select id="year" name="year" v-model="form[l[0]]"
                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option v-for="y in [2019, 2020, 2021, 2022, 2023, 2024, 2025]" :selected="l[0] === y" :key="y" :value="y">{{ y
                }}</option>
              </select>
            </template>
            <template v-else>
              <TextInput :id="l[0]" v-model="form[l[0]]" type="text" class="mt-1 block w-3/4" :placeholder="l[0]" />
            </template>
          </template>
          <template v-else-if="l[1] == 'check'">
            <template v-if="l[2]">
              <template v-for="c in l[2]">
                <label class="flex items-center">
                  <Checkbox :name="c.id" :checked="props.element[l[0]].includes(c.name)" />
                  <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ c.name }}</span>
                </label>
              </template>
            </template>
            <template v-else>
              <Checkbox :name="l[0]" v-model:checked="form[l[0]]" />
            </template>
          </template>
          <template v-else>
            <select
              class="mt-1 block w-3/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
              :name="l[0]" :id="l[0]" v-model="form[l[0]]">
              <option v-for="o in l[1]" :selected="form[l[0] + '_id'] === o.id" :value="o.id">{{ o.name }}</option>
            </select>
          </template>
          <InputError :message="form.errors[l[0]]" class="mt-2" />
        </div>
        <div class="mt-6 flex justify-end">
          <Btn secondary @click="closeModal">Cancel</Btn>
          <Btn primary class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="update">Update</Btn>
        </div>
      </div>
  </Modal>
</div></template>