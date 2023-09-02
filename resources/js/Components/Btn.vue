<script lang="ts" setup>
import { computed } from "vue";

const intents = ["primary", "secondary", "accent", "danger"] as const;
const buttonSizes = ["small", "medium", "big"] as const;
const types = ["button", "submit", "reset"] as const;
type IntentType = (typeof intents)[number];
type SizeType = (typeof buttonSizes)[number];
type typeType = (typeof types)[number];

type ButtonProps = {
  intent?: IntentType;
  size?: SizeType;
  type?: typeType;

  primary?: boolean;
  secondary?: boolean;
  accent?: boolean;
  danger?: boolean;
};

// "primary"
// class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
// "secondary"
// class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
// "danger"
// class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
/*
const props = withDefaults(defineProps<ButtonProps>(), {
  type: 'button',
}
);
*/
const props = defineProps<ButtonProps>();
const btnIntent = computed(() => {
  if (props.primary || props.intent == "primary") return "bg-gray-800 dark:bg-gray-200 border-transparent text-white dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:ring-indigo-500";
  if (props.secondary || props.intent == "secondary") return "bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-500 text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:ring-indigo-500 disabled:opacity-25";
  if (props.danger || props.intent == "danger") return "bg-red-600 border-transparent text-white hover:bg-red-500 active:bg-red-700 focus:ring-red-500";
  return "bg-white dark:bg-gray-800 border-transparent text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:ring-indigo-500";
  /*
  var buttonIntent = props.intent || "";
  intents.forEach((intent) => {
    if (props[intent]) {
      buttonIntent = intent;
    }
  });
  return buttonIntent;
  */
});
const btnType = computed(() => {
  if (props.type) return props.type;
  if (props.secondary || props.intent == "secondary") return "button";
  return;
});
</script>

<template>
  <button :type="btnType"
    class="inline-flex items-center m-1 px-3 py-2 border rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
    :class="[btnIntent, size]">
    <slot />
  </button>
</template>