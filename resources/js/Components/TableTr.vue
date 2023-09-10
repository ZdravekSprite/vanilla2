<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps({
  td1: String,
  td2: String,
  td3: String,
  bold: {
    type: Boolean,
    default: false,
  },
  indent: {
    type: Boolean,
    default: true,
  },
});

const classes = computed(() =>
  props.bold
    ? 'border p-2 font-extrabold' + (props.indent ? ' pl-6' : '')
    : 'border p-2 font-thin' + (props.indent ? ' pl-6' : '')
);
</script>

<template>
  <tr>
    <td class="w-3/4" :class="classes" colspan="2">{{ td1 }}</td>
    <td class="w-1/8 text-center" :class="classes">{{ td2 }}</td>
    <td class="w-1/8 text-right" :class="classes">{{ td3 }}</td>
  </tr>
</template>