<script setup lang="ts">
import Page from '@/Components/Page.vue';

interface Day {
  id: number;
  date: Date;
  _date: string;
  user: string;
  user_id: number;
  firm: string;
  firm_id: number;
  state: number;
  night: string;
  start: string;
  end: string;
}

interface Label {
  id: number;
  name: string;
}

const props = defineProps<{
  all: number;
  days: {
    data: Array<Day>;
    links: Array<object>
  };
  states: Array<Label>;
  firms: Array<Label>;
  users: Array<Label>;
}>();
</script>

<template>
  <Page :all="all" single="day" plural="days" :elements="days"
    :labels_all="[['date'], ['firm', props.firms], ['state', props.states], ['night'], ['start'], ['end']]"
    :labels_show="[['date'], ['user'], ['firm'], ['state']]" />
</template>
