<script setup>
import IconPen from '@/Components/IconPen.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import Btn from '@/Components/Btn.vue';
import IconCalendarPlus from '@/Components/IconCalendarPlus.vue';
import IconSunrise from '@/Components/IconSunrise.vue';
import IconSun from '@/Components/IconSun.vue';
import IconSunset from '@/Components/IconSunset.vue';
import IconMoonStars from '@/Components/IconMoonStars.vue';

const props = defineProps({
  day: Object,
  set: String,
});

const settings = usePage().props.auth.settings ?? {
  start1: '08:00',
  end1: '16:00',
  start2: '16:00',
  end2: '24:00',
  start3: '00:00',
  end3: '08:00',
};

const confirmingUpdate = ref(false);

let state = 0;
let start = null;
let end = null;

if (props.set == 'edit') {
  state = props.day.state;
  start = props.day.start;
  end = props.day.end == '00:00' ? props.day.next_night : props.day.end;
}

if (props.set == 'new' || props.set == 'new1') {
  state = 1;
  start = settings.start1;
  end = settings.end1;
}

if (props.set == 'new2') {
  state = 1;
  start = settings.start2;
  end = settings.end2;
}

if (props.set == 'new3') {
  state = 1;
  start = settings.start3;
  end = settings.end3;
}

const form = useForm({
  id: props.day.id,
  date: props.day.date,
  user: props.day.user_id,
  firm: props.day.firm_id,
  state: state,
  start: start,
  end: end,
});

const confirmUpdate = () => {
  confirmingUpdate.value = true;
  console.log(props)
};

const update = () => {
  form.patch(route('day.update', props.day.id), {
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
    <Btn secondary @click="confirmUpdate" class="ring-inset m-0">
      <IconPen v-if="set == 'edit'" class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
      <IconCalendarPlus v-if="set == 'new1'" class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
      <IconSun v-if="set == 'new2'" class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
      <IconMoonStars v-if="set == 'new3'" class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
    </Btn>

    <Modal :show="confirmingUpdate" @close="closeModal">
      <div class="p-6 space-y-4">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Edit {{ props.day.date ?? props.day.id + '. element' }} for {{ props.day.user }} in {{ props.day.firm }}?
        </h2>
        <div>
          <InputLabel for="state" value="Vrsta dana" />
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