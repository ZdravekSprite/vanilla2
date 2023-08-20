<script setup lang="ts">
import IconPerson from '@/Components/IconPerson.vue';
import { usePage, useForm } from '@inertiajs/vue3';
import Btn from '@/Components/Btn.vue';

const props = defineProps({
  user: {
    type: Object,
    default: null,
  },
});

const authUser = usePage().props.auth.user;

const form = useForm({
  id: props.user.id});

const impersonate = () => {
  form.get(route('user.start', [props.user.id]), {
    onError: () => console.log('error'),
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <div v-if="props.user.id !== authUser.id">
    <Btn secondary @click="impersonate">
      <IconPerson class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
    </Btn>
  </div>
</template>