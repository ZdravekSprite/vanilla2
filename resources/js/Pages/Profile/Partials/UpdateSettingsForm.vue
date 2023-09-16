<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Btn from '@/Components/Btn.vue';
import { ref } from 'vue';

const settings = usePage().props.auth.settings;

const form = useForm({
  start1: (settings && settings.start1) ? settings.start1 : '08:00',
  end1: (settings && settings.end1) ? settings.end1 : '16:00',
  start2: (settings && settings.start2) ? settings.start2 : '16:00',
  end2: (settings && settings.end2) ? settings.end2 : '22:00',
  start3: (settings && settings.start3) ? settings.start3 : '22:00',
  end3: (settings && settings.end3) ? settings.end3 : '08:00',
  key: (settings && settings.BINANCE_API_KEY) ? settings.BINANCE_API_KEY : '',
  secret: (settings && settings.BINANCE_API_SECRET) ? settings.BINANCE_API_SECRET : '',
});
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Settings Information</h2>

      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        Update your account's settings information and email address.
      </p>
    </header>

    <form @submit.prevent="form.patch(route('settings.update'))" class="mt-6 space-y-6">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <InputLabel for="start1" value="start1" />
          <TextInput id="start1" type="time" class="mt-1 block w-full" v-model="form.start1" />
          <InputError class="mt-2" :message="form.errors.start1" />
        </div>
        <div>
          <InputLabel for="end1" value="end1" />
          <TextInput id="end1" type="time" class="mt-1 block w-full" v-model="form.end1" />
          <InputError class="mt-2" :message="form.errors.end1" />
        </div>
        <div>
          <InputLabel for="start2" value="start2" />
          <TextInput id="start2" type="time" class="mt-1 block w-full" v-model="form.start2" />
          <InputError class="mt-2" :message="form.errors.start2" />
        </div>
        <div>
          <InputLabel for="end2" value="end2" />
          <TextInput id="end2" type="time" class="mt-1 block w-full" v-model="form.end2" />
          <InputError class="mt-2" :message="form.errors.end2" />
        </div>
        <div>
          <InputLabel for="start3" value="start3" />
          <TextInput id="start3" type="time" class="mt-1 block w-full" v-model="form.start3" />
          <InputError class="mt-2" :message="form.errors.start3" />
        </div>
        <div>
          <InputLabel for="end3" value="end3" />
          <TextInput id="end3" type="time" class="mt-1 block w-full" v-model="form.end3" />
          <InputError class="mt-2" :message="form.errors.end3" />
        </div>
      </div>
      <div>
        <InputLabel for="key" value="BINANCE_API_KEY" />
        <TextInput id="key" type="text" class="mt-1 block w-full" v-model="form.key" />
        <InputError class="mt-2" :message="form.errors.key" />
      </div>

      <div>
        <InputLabel for="secret" value="BINANCE_API_SECRET" />
        <TextInput id="secret" type="text" class="mt-1 block w-full" v-model="form.secret" />
        <InputError class="mt-2" :message="form.errors.secret" />
      </div>

      <div class="flex items-center gap-4">
        <Btn primary :disabled="form.processing">Save</Btn>

        <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
          <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
        </Transition>
      </div>
    </form>
  </section>
</template>
