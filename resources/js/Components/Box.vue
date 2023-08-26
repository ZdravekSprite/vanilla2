<script setup lang="ts">
defineProps<{
  header?: string | number | Array<string | number>;
  value?: number;
  limit?: number;
}>();
</script>

<template>
  <div v-if="(typeof limit == 'undefined') || (typeof value != 'undefined' && typeof limit != 'undefined' && value <= limit)" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
    <h2>{{ header }}</h2>
    <span v-if="(typeof value != 'undefined')">{{ value }}</span>
    <span v-else>
      <slot />
    </span>
  </div>
</template>