<script setup>
import IconPen from '@/Components/IconPen.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Btn from '@/Components/Btn.vue';

const props = defineProps({
  day: Object,
  updateRoute: String,
  labels: Array,
});

const confirmingUpdate = ref(false);

const form = useForm({
  id: props.day.id,
  date: props.day.date,
  state: props.day.state ?? 0,
  start: props.day.start ?? '08:00',
  end: props.day.end ?? '16:00',
});

const confirmUpdate = () => {
  confirmingUpdate.value = true;
};

const update = () => {
  form.patch(route(props.updateRoute, props.day.id), {
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
      <IconPen class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
    </Btn>

    <Modal :show="confirmingUpdate" @close="closeModal">
      <div class="p-6 space-y-4">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Edit {{ props.day.date ?? props.day.id + '. element' }}?
        </h2>
        <div>
          <InputLabel for="satate" value="Vrsta dana" />
          <select id="state" name="state" v-model="form.state"
            class="block mt-1 w-w-3/4 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option v-for="x, y in ['Nisam radio/la', 'Radio/la normalno', 'Godišnji', 'Plaćeni dopust', 'Bolovanje']"
              :selected="form.state == y" :key="y" :value="y">{{ x }}</option>
          </select>
          <InputError :message="form.errors['state']" class="mt-2" />
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Odabrati, da li se radilo ili ne? Bolovanje? Godišnji?
          </p>
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Da li ste taj dan dobili plačeni dopust?</p>
        </div>
        <!-- start -->
        <div :hidden="form.state != 1" id="start_div">
          <InputLabel for="start" value="Početak smjene" />
          <TextInput v-model="form.start" id="start" type="time" name="start" class="mt-1 block w-3/4" :value="form.start"
            required />
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Vrijeme kada je započela smjena.</p>
        </div>
        <!-- end -->
        <div :hidden="form.state != 1" id="end_div">
          <InputLabel for="end" value="Kraj smjene" />
          <TextInput v-model="form.end" id="end" type="time" name="end" class="mt-1 block w-3/4" :value="form.end"
            required />
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Vrijeme kada je završila smjena.</p>
        </div>
        <div class="mt-6 flex justify-end">
          <Btn secondary @click="closeModal">Cancel</Btn>
          <Btn primary class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="update">Update</Btn>
        </div>
      </div>
    </Modal>
  </div>
</template>