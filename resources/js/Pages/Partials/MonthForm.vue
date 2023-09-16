<script setup>
import IconPen from '@/Components/IconPen.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Btn from '@/Components/Btn.vue';

const props = defineProps({
  month: Object,
});

console.log(props.month);

const confirmingUpdate = ref(false);

const form = useForm(props.month);

const confirmUpdate = () => {
  confirmingUpdate.value = true;
  console.log(props)
};

const update = () => {
  form.patch(route('month.update'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => console.log('error'),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingUpdate.value = false;
  form.reset();
  form.clearErrors();
};
</script>

<template>
  <div>
    <Btn secondary @click="confirmUpdate">
      <IconPen class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
    </Btn>

    <Modal :show="confirmingUpdate" @close="closeModal">
      <div class="p-6 space-y-4">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Edit {{ props.month.slug ?? props.month.id + '.element' }}?
        </h2>
        <div class="grid grid-cols-3 gap-1">
          <!-- bruto -->
          <div id="bruto_div" class="mt-6">
            <InputLabel for="bruto" value="Bruto" />
            <TextInput v-model="form.bruto" id="bruto" type="number" name="bruto" step="0.01" class="mt-1 block"
              :value="form.bruto" required />
          </div>
          <!-- prirez -->
          <div id="prirez_div" class="mt-6">
            <InputLabel for="prirez" value="Prirez" />
            <TextInput v-model="form.prirez" id="prirez" type="number" name="prirez" step="0.01" class="mt-1 block"
              :value="form.prirez" required />
          </div>
          <!-- minuli -->
          <div id="minuli_div" class="mt-6">
            <InputLabel for="minuli" value="Minuli rad" />
            <TextInput v-model="form.minuli" id="minuli" type="number" name="minuli" step="0.01" class="mt-1 block"
              :value="form.minuli" required />
          </div>
          <!-- prijevoz -->
          <div id="prijevoz_div" class="mt-6">
            <InputLabel for="prijevoz" value="Prijevoz" />
            <TextInput v-model="form.prijevoz" id="prijevoz" type="number" name="prijevoz" step="0.01" class="mt-1 block"
              :value="form.prijevoz" required />
          </div>
          <!-- prehrana -->
          <div id="prehrana_div" class="mt-6">
            <InputLabel for="prehrana" value="Prehrana" />
            <TextInput v-model="form.prehrana" id="prehrana" type="number" name="prehrana" step="0.01" class="mt-1 block"
              :value="form.prehrana" required />
          </div>
          <!-- odbitak -->
          <div id="odbitak_div" class="mt-6">
            <InputLabel for="odbitak" value="Odbitak" />
            <TextInput v-model="form.odbitak" id="odbitak" type="number" name="odbitak" step="0.01" class="mt-1 block"
              :value="form.odbitak" required />
          </div>
          <!-- nagrada -->
          <div id="nagrada_div" class="mt-6">
            <InputLabel for="nagrada" value="Nagrada" />
            <TextInput v-model="form.nagrada" id="nagrada" type="number" name="nagrada" step="0.01" class="mt-1 block"
              :value="form.nagrada" required />
          </div>
          <!-- regres -->
          <div id="regres_div" class="mt-6">
            <InputLabel for="regres" value="Regres" />
            <TextInput v-model="form.regres" id="regres" type="number" name="regres" step="0.01" class="mt-1 block"
              :value="form.regres" required />
          </div>
          <!-- prigodna -->
          <div id="prigodna_div" class="mt-6">
            <InputLabel for="prigodna" value="Prigodna" />
            <TextInput v-model="form.prigodna" id="prigodna" type="number" name="prigodna" step="0.01" class="mt-1 block"
              :value="form.prigodna" required />
          </div>
          <!-- sindikat -->
          <div id="sindikat_div" class="mt-6">
            <InputLabel for="sindikat" value="Sindikat" />
            <TextInput v-model="form.sindikat" id="sindikat" type="number" name="sindikat" step="0.01" class="mt-1 block"
              :value="form.sindikat" required />
          </div>
          <!-- stimulacija -->
          <div id="stimulacija_div" class="mt-6">
            <InputLabel for="stimulacija" value="Stimulacija" />
            <TextInput v-model="form.stimulacija" id="stimulacija" type="number" name="stimulacija" step="0.01"
              class="mt-1 block" :value="form.stimulacija" required />
          </div>
          <!-- bozicnica -->
          <div id="bozicnica_div" class="mt-6">
            <InputLabel for="bozicnica" value="Božičnica" />
            <TextInput v-model="form.bozicnica" id="bozicnica" type="number" name="bozicnica" step="0.01"
              class="mt-1 block" :value="form.bozicnica" required />
          </div>
          <!-- kredit -->
          <div id="kredit_div" class="mt-6">
            <InputLabel for="kredit" value="Kredit" />
            <TextInput v-model="form.kredit" id="kredit" type="number" name="kredit" step="0.01" class="mt-1 block"
              :value="form.kredit" required />
          </div>
        </div>
        <div class="mt-6 flex justify-end">
          <Btn secondary @click="closeModal">Cancel</Btn>
          <Btn primary class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="update">Update</Btn>
        </div>
      </div>
    </Modal>
  </div>
</template>