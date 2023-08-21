<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import Btn from '@/Components/Btn.vue';

</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Settings Information</h2>

      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        Update your account's settings information and email address.
      </p>
    </header>
  </section>
</template>
