<script setup lang="ts">
import IconPerson from '@/Components/IconPerson.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { usePage, useForm } from '@inertiajs/vue3';

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
    <SecondaryButton @click="impersonate">
      <IconPerson class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
    </SecondaryButton>
  </div>
</template>