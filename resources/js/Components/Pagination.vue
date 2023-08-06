<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
const props = defineProps({
  links: {
    type: Array,
    default: [],
  },
  search: {
    type: String,
    default: null,
  },
  checked: {
    type: Boolean,
    default: false,
  },
});
const search = computed(() =>
  props.search
    ? props.checked
      ? '&search=' + props.search + '&checked=' + props.checked
      : '&search=' + props.search
    : props.checked
      ? '&checked=' + props.checked
      : ''
);
</script>

<template>
  <Component :is="link.url ? Link : 'span'" v-for="link in links" :href="link.url + search" v-html="link.label"
    class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
    :class="{ 'text-gray-500 dark:text-gray-500': !link.url, 'bg-gray-100 dark:bg-gray-900': link.active }" />
</template>