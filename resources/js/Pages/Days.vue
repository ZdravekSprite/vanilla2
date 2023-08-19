<script setup lang="ts">
import Page from '@/Components/Page.vue';

const props = defineProps<{
  all: number;
  days: {
    data: Array<{
      id: number;
      date: Date;
      user: String;
      user_id: number;
      firm: String;
      firm_id: number;
      state: number;
      night: String;
      start: String;
      end: String;
    }>;
    links: Array<object>
  };
  firms: Array<{
    id: number;
    name: String;
  }>;
  users: Array<{
    id: number;
    name: String;
  }>;
}>();
console.log(props);
</script>

<template>
  <Page :all="all" single="day" plural="days" :elements="days"
    :labels_all="[['date'], ['firm', props.firms], ['state'], ['night'], ['start'], ['end']]"
    :labels_show="[['date'], ['user', props.users], ['firm', props.firms], ['state']]" />
</template>
