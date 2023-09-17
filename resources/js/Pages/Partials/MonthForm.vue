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

const showForm = ref(false);
const clickShowForm = () => {
  showForm.value = true;
};
const showPanel1 = ref(true);
const clickShowPanel1 = () => {
  showPanel1.value = !showPanel1.value;
  showPanel2.value = !showPanel1.value;
  showPanel3.value = !showPanel1.value;
};
const showPanel2 = ref(false);
const clickShowPanel2 = () => {
  showPanel2.value = !showPanel2.value;
  showPanel1.value = !showPanel2.value;
  showPanel3.value = !showPanel2.value;
};
const showPanel3 = ref(false);
const clickShowPanel3 = () => {
  showPanel3.value = !showPanel3.value;
  showPanel1.value = !showPanel3.value;
  showPanel2.value = !showPanel3.value;
};

const form = useForm(props.month);

const update = () => {
  form.patch(route('month.update'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => console.log('error'),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  showForm.value = false;
  form.reset();
  form.clearErrors();
};
</script>

<template>
  <div>
    <Btn secondary @click="clickShowForm">
      <IconPen class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
    </Btn>

    <Modal :show="showForm" @close="closeModal">
      <div class="p-6 space-y-4">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Edit {{ props.month.slug ?? props.month.id + '.element' }}?
          <Btn v-if="!showPanel1" @click="clickShowPanel1">show Panel1</Btn>
          <Btn v-if="!showPanel2" @click="clickShowPanel2">show Panel2</Btn>
          <Btn v-if="!showPanel3" @click="clickShowPanel3">show Panel3</Btn>
        </h2>
        <div v-if="showPanel1" class="grid grid-cols-3 gap-1">
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
        <div v-if="showPanel2" class="grid grid-cols-4 gap-1">
          <!-- radni sati h01 v01 dan h02 v02 noć -->
          <div id="h01_div" class="mt-6">
            <InputLabel for="h01" value="radni sati dan" />
            <TextInput v-model="form.h01" id="h01" type="number" name="h01" step="0.1" class="mt-1 block"
              :value="form.h01" required />
          </div>
          <div id="v01_div" class="mt-6">
            <InputLabel for="v01" value="v01" />
            <TextInput v-model="form.v01" id="v01" type="number" name="v01" step="0.1" class="mt-1 block"
              :value="form.v01" required />
          </div>
          <div id="h02_div" class="mt-6">
            <InputLabel for="h02" value="radni sati noć" />
            <TextInput v-model="form.h02" id="h02" type="number" name="h02" step="0.1" class="mt-1 block"
              :value="form.h02" required />
          </div>
          <div id="v02_div" class="mt-6">
            <InputLabel for="v02" value="v02" />
            <TextInput v-model="form.v02" id="v02" type="number" name="v02" step="0.1" class="mt-1 block"
              :value="form.v02" required />
          </div>
          <!-- radni sati h03 v03 nedelja h04 v04 nedelja noć -->
          <div id="h03_div" class="mt-6">
            <InputLabel for="h03" value="radni sati nedelja" />
            <TextInput v-model="form.h03" id="h03" type="number" name="h03" step="0.1" class="mt-1 block"
              :value="form.h03" required />
          </div>
          <div id="v03_div" class="mt-6">
            <InputLabel for="v03" value="v03" />
            <TextInput v-model="form.v03" id="v03" type="number" name="v03" step="0.1" class="mt-1 block"
              :value="form.v03" required />
          </div>
          <div id="h04_div" class="mt-6">
            <InputLabel for="h04" value="radni sati nedelja noć" />
            <TextInput v-model="form.h04" id="h04" type="number" name="h04" step="0.1" class="mt-1 block"
              :value="form.h04" required />
          </div>
          <div id="v04_div" class="mt-6">
            <InputLabel for="v04" value="v04" />
            <TextInput v-model="form.v04" id="v04" type="number" name="v04" step="0.1" class="mt-1 block"
              :value="form.v04" required />
          </div>
          <!-- radni sati h05 v05 blagdan h06 v06 blagdan noć -->
          <div id="h05_div" class="mt-6">
            <InputLabel for="h05" value="radni sati blagdan" />
            <TextInput v-model="form.h05" id="h05" type="number" name="h05" step="0.1" class="mt-1 block"
              :value="form.h05" required />
          </div>
          <div id="v05_div" class="mt-6">
            <InputLabel for="v05" value="v05" />
            <TextInput v-model="form.v05" id="v05" type="number" name="v05" step="0.1" class="mt-1 block"
              :value="form.v05" required />
          </div>
          <div id="h06_div" class="mt-6">
            <InputLabel for="h06" value="radni sati blagdan noć" />
            <TextInput v-model="form.h06" id="h06" type="number" name="h06" step="0.1" class="mt-1 block"
              :value="form.h06" required />
          </div>
          <div id="v06_div" class="mt-6">
            <InputLabel for="v06" value="v06" />
            <TextInput v-model="form.v06" id="v06" type="number" name="v06" step="0.1" class="mt-1 block"
              :value="form.v06" required />
          </div>
          <!-- radni sati h07 v07 nedelja i blagdan h08 v08 nedelja i blagdan noć -->
          <div id="h07_div" class="mt-6">
            <InputLabel for="h07" value="radni sati nedelja i blagdan" />
            <TextInput v-model="form.h07" id="h07" type="number" name="h07" step="0.1" class="mt-1 block"
              :value="form.h07" required />
          </div>
          <div id="v07_div" class="mt-6">
            <InputLabel for="v07" value="v07" />
            <TextInput v-model="form.v07" id="v07" type="number" name="v07" step="0.1" class="mt-1 block"
              :value="form.v07" required />
          </div>
          <div id="h08_div" class="mt-6">
            <InputLabel for="h08" value="radni sati nedelja i blagdan noć" />
            <TextInput v-model="form.h08" id="h08" type="number" name="h08" step="0.1" class="mt-1 block"
              :value="form.h08" required />
          </div>
          <div id="v08_div" class="mt-6">
            <InputLabel for="v08" value="v08" />
            <TextInput v-model="form.v08" id="v08" type="number" name="v08" step="0.1" class="mt-1 block"
              :value="form.v08" required />
          </div>
          <div v-if="showPanel3">
            <!-- 
            //prekovremeni rad
            $table->tinyInteger('h09')->nullable();
            $table->mediumInteger('v09')->nullable();
            //godišnji odmor
            $table->tinyInteger('h10')->nullable();
            $table->mediumInteger('v10')->nullable();
            //bolovanje
            $table->tinyInteger('h11')->nullable();
            $table->mediumInteger('v11')->nullable();
            //blagdani,izbori
            $table->tinyInteger('h12')->nullable();
            $table->mediumInteger('v12')->nullable();
            //plaćeni dopust
            $table->tinyInteger('h13')->nullable();
            $table->mediumInteger('v13')->nullable();
            -->
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