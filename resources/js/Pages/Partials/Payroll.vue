<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
  next: String;
  prev: String;
  next_id: number;
  prev_id: number;
}>();
</script>

<template>
  <table class="table-auto w-full" id="payroll">
    <caption class="caption-top">
      <div class="flex justify-between">
        <div>
          <Link :href="route('month', prev_id)" :title="prev">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
            class="bi bi-arrow-left-square" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
              d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
          </svg>
          </Link>
        </div>
        <div>
          <Link :href="route('month', next_id)" :title="next">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
            class="bi bi-arrow-right-square" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
              d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 5.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
          </svg>
          </Link>
        </div>
      </div>
    </caption>
    <thead>
      <tr>
        <th class="w-1/2 text-left"><b>OBRAČUN ISPLAĆENE PLAĆE</b></th>
        <th class="w-1/2 text-right" colspan="3"><b>Obrazac IP1</b></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="border p-2">
          <ul>
            <li><b>I. PODACI O POSLODAVCU</b></li>
            <li>1. Tvrtka/ Ime i prezime: ____</li>
            <li>2. Sjedište / Adresa: ____</li>
            <li>3. Osobni identifikacijski broj: ____</li>
            <li>4. IBAN broj računa ____ kod ____</li>
          </ul>
        </td>
        <td class="border p-2" colspan="3">
          <ul>
            <li><b>II. PODACI O RADNIKU/RADNICI</b></li>
            <li>
              1. Ime i prezime: ___
            </li>
            <li>2. Adresa: ____</li>
            <li>3. Osobni identifikacijski broj: ____</li>
            <li>4. IBAN broj računa ____ kod ____</li>
            <li>5. IBAN broj računa iz čl. 212. Ovršnog zakona ____ kod ____</li>
          </ul>
        </td>
      </tr>
      <tr>
        <td class="border p-2" colspan="4"><b>III. RAZDOBLJE NA KOJE SE PLAĆA ODNOSI:</b> GODINA ___, MJESEC ___ DANI U
          MJESECU OD ___ DO ___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2" colspan="2"><b>1. OPIS PLAĆE</b></td>
        <td class="w-1/8 border p-2 text-center"><b>SATI</b></td>
        <td class="w-1/8 border p-2 text-right"><b>IZNOS</b></td>
      </tr>
    </tbody>
  </table>
</template>