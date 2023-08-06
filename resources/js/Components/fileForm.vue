<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  title: {
    type: String,
    default: "Form",
  },
  link: {
    type: String,
    default: "",
  },
  fileName: {
    type: String,
    default: 'fileName.csv',
  },
});

const confirmingForm = ref(false);
const fileNameInput = ref(props.fileName);

const form = useForm({
  fileName: props.fileName,
});

const confirmForm = () => {
  confirmingForm.value = true;
};

const formData = () => {
  form.post(route(props.link), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => console.log('error'),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingForm.value = false;
  form.reset();
};
</script>

<template>
  <div>
    <SecondaryButton @click="confirmForm">
      {{ props.title }}
    </SecondaryButton>

    <Modal :show="confirmingForm" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          {{ props.title }}?
        </h2>
        <div class="mt-6">
          <InputLabel for="fileName" value="File Name" class="sr-only" />
          <TextInput id="fileName" ref="fileNameForm" v-model="form.fileName" type="text" class="mt-1 block w-3/4"
            placeholder="File Name" @keyup.enter="formData" />
          <InputError :message="form.errors.fileName" class="mt-2" />
        </div>
        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
          <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="formData">
            {{ props.title }}
          </PrimaryButton>
        </div>
      </div>
    </Modal>
  </div>
</template>