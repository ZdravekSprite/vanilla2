<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Btn from '@/Components/Btn.vue';

const settings = usePage().props.auth.settings;

const form = useForm({
  start1: (settings && settings.start1) ? settings.start1 : '00:00',
  end1: (settings && settings.start1) ? settings.start1 : '00:00',
  start2: (settings && settings.start1) ? settings.start1 : '00:00',
  end2: (settings && settings.start1) ? settings.start1 : '00:00',
  start3: (settings && settings.start1) ? settings.start1 : '00:00',
  end3: (settings && settings.start1) ? settings.start1 : '00:00',
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
