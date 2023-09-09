<script setup lang="ts">
import TableTr from '@/Components/TableTr.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
  month: {
    first: string,
    last: string,
    bruto: string,
    h01: string,
    v01: string,
    h02: string,
    v02: string,
    h03: string,
    v03: string,
    h04: string,
    v04: string,
    h05: string,
    v05: string,
    h06: string,
    v06: string,
    h07: string,
    v07: string,
    h08: string,
    v08: string,
    h09: string,
    v09: string,
    h10: string,
    v10: string,
    h11: string,
    v11: string,
    h12: string,
    v12: string,
    h13: string,
    v13: string,
  };
  next: String,
  prev: String,
  next_id: number,
  prev_id: number,
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
              1. Ime i prezime: {{ $page.props.auth.user.name }}
            </li>
            <li>2. Adresa: ____</li>
            <li>3. Osobni identifikacijski broj: ____</li>
            <li>4. IBAN broj računa ____ kod ____</li>
            <li>5. IBAN broj računa iz čl. 212. Ovršnog zakona ____ kod ____</li>
          </ul>
        </td>
      </tr>
      <tr>
        <td class="border p-2" colspan="4"><b>III. RAZDOBLJE NA KOJE SE PLAĆA ODNOSI:</b> GODINA {{ new
          Date(month.first).getFullYear() }}, MJESEC {{ new Date(month.first).getMonth() + 1 }} DANI U MJESECU OD {{ new
    Date(month.first).getDate() }} DO {{ new Date(month.last).getDate() }}</td>
      </tr>
      <TableTr td1="1. OPIS PLAĆE" td2="SATI" td3="IZNOS" :bold="true" :indent="false" />
      <TableTr v-if="month.h01 != '0'" td1="1.1. Za redoviti rad" :td2="month.h01 + ''" :td3="month.v01 + ''" />
      <TableTr v-if="month.h09 != '0'" td1="1.4 Za prekovremeni rad" :td2="month.h09 + ''" :td3="month.v09 + ''" />
      <TableTr v-if="month.h12 != '0'" td1="1.7a Praznici. Blagdani, izbori" :td2="month.h12 + ''" :td3="month.v12 + ''" />
      <TableTr v-if="month.h10 != '0'" td1="1.7b Godišnji odmor" :td2="month.h10 + ''" :td3="month.v10 + ''" />
      <TableTr v-if="month.h13 != '0'" td1="1.7c Plaćeni dopust" :td2="month.h13 + ''" :td3="month.v13 + ''" />
      <TableTr v-if="month.h11 != '0'" td1="1.7d Bolovanje do 42 dana" :td2="month.h11 + ''" :td3="month.v11 + ''" />
      <TableTr v-if="month.h03 != '0'" td1="1.7e Dodatak za rad nedjeljom" :td2="month.h03 + ''" :td3="month.v03 + ''" />
      <TableTr v-if="month.h05 != '0'" td1="1.7f Dodatak za rad na praznik" :td2="month.h05 + ''" :td3="month.v05 + ''" />
      <TableTr v-if="month.h02 != '0'" td1="1.7g Dodatak za noćni rad" :td2="month.h02 + ''" :td3="month.v02 + ''" />
      <TableTr td1="1.7.P Nagrada za radne rezultate" td3="_" />
      <tr>
        <td class="w-3/4 border p-2" colspan="2">2. OSTALI OBLICI RADA TEMELJEM KOJIH OSTVARUJE PRAVO NA UVEĆANJE PLAĆE
          PREMA KOLEKTIVNOM UGOVORU, PRAVILNIKU O RADU ILI UGOVORU O RADU I NOVČANI IZNOS PO TOJ OSNOVI (SATI
          PRIPRAVNOSTI)</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">2.8. Stimulacija bruto</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2" colspan="2">3. PROPISANI ILI UGOVORENI DODACI NA PLAĆU RADNIKA I NOVČANI IZNOSI PO
          TOJ OSNOVI</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">3.1. Prijevoz</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">3.7. Regres za godišnji odmor</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2" colspan="2">4. ZBROJENI IZNOSI PRIMITAKA PO SVIM OSNOVAMA PO STAVKAMA 1. DO 3.</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2" colspan="2"><b>5. OSNOVICA ZA OBRAČUN DOPRINOSA</b></td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right"><b>___</b></td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2" colspan="2">6. VRSTE I IZNOSI DOPRINOSA ZA OBVEZNA OSIGURANJA KOJA SE OBUSTAVLJAJU IZ
          PLAĆ</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right"></td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">6.1. za mirovinsko osiguranje na temelju generacijske solidarnosti
          (I. STUP)</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">6.2 za mirovinsko osiguranje na temelju individualne kapitalizirane
          štednje (II. STUP)</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2" colspan="2"><b>7. DOHODAK</b></td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right"><b>___</b></td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2" colspan="2">8. OSOBNI ODBITAK 1.00 / ___</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2" colspan="2">9. POREZNA OSNOVICA</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2" colspan="2">10. IZNOS PREDUJMA POREZA I PRIREZA POREZU NA DOHODAK</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">20.00% ___</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-12" colspan="2">Prirez ___ %</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2" colspan="2"><b>11. NETO PLAĆA</b></td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right"><b>___</b></td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2" colspan="2">12. NAKNADE UKUPNO</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2" colspan="2"><b>13. NETO + NAKNADE</b></td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right"><b>___</b></td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2" colspan="2"><b>14. OBUSTAVE UKUPNO</b></td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right"><b>___</b></td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2" colspan="2"><b>15. IZNOS PLAĆE/NAKNADE PLAĆE ISPLAĆEN RADNIKU NA REDOVAN RAČUN</b>
        </td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right"><b>___</b></td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2" colspan="2">17.5. vrsta i iznos obustave</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right"></td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">Sindikalna članarina</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">Kredit</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
    </tbody>
</table></template>