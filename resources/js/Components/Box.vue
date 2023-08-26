<script setup lang="ts">
defineProps<{
  header?: string | number | Array<string | number>;
  value?: string | number | Array<string | number>;
}>();
</script>

<template>
  <div class="block font-medium text-sm text-gray-700 dark:text-gray-300">
    <h2>{{ header }}</h2>
    <span v-if="value">{{ value }}</span>
    <span v-else>
      <slot />
    </span>
  </div>
</template>