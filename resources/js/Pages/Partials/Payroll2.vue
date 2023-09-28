<script setup lang="ts">
import TableTr from '@/Components/TableTr.vue';
import { Link } from '@inertiajs/vue3';

interface Norm {
  Full: number;
  All: number;
  min: number;
  minHoli: number;
  minHoliNight: number;
  minHoliSunday: number;
  minHoliSundayNight: number;
  minNight: number;
  minSunday: number;
  minSundayNight: number;
}
interface Firm {
  id: number;
  name: string;
  address: string;
  oib: string;
  iban: string;
  bank: string;
}
interface User {
  id: number;
  name: String;
  email: String;
  roles: Array<object>;
  isSuper: boolean;
}
const props = defineProps<{
  firm: Firm;
  user: User;
  month: {
    norm: Norm,
    valuta: string,
    bruto: number,
    minuli: number,
    odbitak: number,
    prirez: number,
    prijevoz: number,
    prehrana: number,
    stimulacija: number,
    nagrada: number,
    regres: number,
    bozicnica: number,
    prigodna: number,
    kredit: number,
    sindikat: number,
    first: string,
    last: string,
    h01: number,
    v01: number,
    h02: number,
    v02: number,
    h03: number,
    v03: number,
    h04: number,
    v04: number,
    h05: number,
    v05: number,
    h06: number,
    v06: number,
    h07: number,
    v07: number,
    h08: number,
    v08: number,
    h09: number,
    v09: number,
    h10: number,
    v10: number,
    h11: number,
    v11: number,
    h12: number,
    v12: number,
    h13: number,
    v13: number,
  };
  next: String,
  prev: String,
  next_id: number,
  prev_id: number,
}>();
const t1 = Math.round((props.month.v01 + props.month.v02 + props.month.v03 + props.month.v04 + props.month.v05 + props.month.v06 + props.month.v07 + props.month.v08) * 100) / 100;
const t2 = props.month.stimulacija + props.month.v10 + props.month.v12;
const t3 = props.month.prijevoz + props.month.regres;
const tm = props.month.minuli ? Math.round(props.month.minuli * (t1 + t2)) / 100 : 0;
const t4 = Math.round((t1 + t2 + tm) * 100) / 100;
const t5 = t4;
const t6 = Math.round(t5 * 15) / 100 + Math.round(t5 * 5) / 100;
const t7 = Math.round((t5 - t6) * 100) / 100;
const t8 = t7 - props.month.odbitak > 0 ? props.month.odbitak : t7;
const t9 = Math.round((t7 - t8) * 100) / 100;
const t10 = (Math.round(t9 * 20) + Math.round(Math.round(t9 * 20) / 100 * props.month.prirez)) / 100;
const t11 = Math.round((t7 - t10) * 100) / 100;
const t12 = Math.round((props.month.prijevoz + props.month.prehrana + props.month.nagrada + props.month.prigodna) * 100) / 100;
const t13 = Math.round((t11 + t12) * 100) / 100;
const t14 = props.month.sindikat + props.month.kredit;
const t15 = t13 - t14;
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
            <li>1. Tvrtka/ Ime i prezime: {{ firm.name }}</li>
            <li>2. Sjedište / Adresa: {{ firm.address }}</li>
            <li>3. Osobni identifikacijski broj: {{ firm.oib }}</li>
            <li>4. IBAN broj računa {{ firm.iban }} kod {{ firm.bank }}</li>
          </ul>
        </td>
        <td class="border p-2" colspan="3">
          <ul>
            <li><b>II. PODACI O RADNIKU/RADNICI</b></li>
            <li>
              1. Ime i prezime: {{ user.name }}
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

      <TableTr td1="1. OSTVARENI SATI PO VREMENU" td2="sati rada" :td3="'iznos' + month.valuta" :bold="true"
        :indent="false" />
      <TableTr v-if="month.h01 != 0" td1="1.1. sati redovnog rada" :td2="month.h01 + '(' + month.norm.min + ')'"
        :td3="month.v01 + ''" />
      <TableTr v-if="month.h02 != 0" td1="1.2. sati redovnog rada noću" :td2="month.h02 + '(' + month.norm.minNight + ')'"
        :td3="month.v02 + ''" />
      <TableTr v-if="month.h05 != 0" td1="1.3. sati redovnog rada u dane državnog praznika/blagdana"
        :td2="month.h05 + '(' + month.norm.minHoli + ')'" :td3="month.v05 + ''" />
      <TableTr v-if="month.h03 != 0" td1="1.7. sati redovnog rada nedeljom"
        :td2="month.h03 + '(' + month.norm.minSunday + ')'" :td3="month.v03 + ''" />
      <TableTr v-if="month.h04 != 0" td1="1.8. sati redovnog rada nedeljom + noću"
        :td2="month.h04 + '(' + month.norm.minSundayNight + ')'" :td3="month.v04 + ''" />
      <TableTr v-if="month.h07 != 0" td1="1.9. sati redovnog rada nedeljom + drž.praznikom/blagdanom"
        :td2="month.h07 + '(' + month.norm.minHoliSunday + ')'" :td3="month.v07 + ''" />
      <TableTr v-if="month.h06 != 0" td1="1.10. sati redovnog rada drž.praznikom/blagdanom + noću"
        :td2="month.h06 + '(' + month.norm.minHoliNight + ')'" :td3="month.v06 + ''" />
      <TableTr v-if="month.h08 != 0" td1="sati redovnog rada nedeljom + drž.praznikom/blagdanom + noću"
        :td2="month.h08 + '(' + month.norm.minHoliSundayNight + ')'" :td3="month.v08 + ''" />

      <TableTr v-if="t2 != 0" td1="2. SATI ZA KOJE SE OSTVARUJE PRAVO NA NAKNADU" :indent="false" />
      <TableTr v-if="month.h10 != 0" td1="2.1. sati godišnjeg odmora" :td2="month.h10 + ''" :td3="month.v10 + ''" />
      <TableTr v-if="month.h12 != 0" td1="2.3. sati blagdana i neradnih dana" :td2="month.h12 + ''"
        :td3="month.v12 + ''" />

      <TableTr td1="Propisani ili ugovoreni dodaci na plaću radnika i novčani iznosi po toj osnovi" :indent="false" />
      <TableTr v-if="month.minuli != 0" td1="Minuli rad" :td2="month.minuli + ''" :td3="tm + month.valuta" />

      <TableTr td1="ZBROJENI IZNOSI PRIMITAKA PO SVIM OSNOVAMA - BRUTTO PLAĆA" :td3="t4 ? t4 + month.valuta : ''"
        :indent="false" />

      <TableTr td1="OSNOVICA ZA OBRAČUN DOPRINOSA" :td3="t5 + month.valuta" :indent="false" />

      <TableTr td1="Vrste i iznosi doprinosa za obvezna osiguranja koji se obustavljaju iz plaće" :indent="false" />
      <TableTr td1="MIO" :td3="(Math.round(t5 * 15) / 100) + month.valuta" />
      <TableTr td1="MIO II" :td3="(Math.round(t5 * 5) / 100) + month.valuta" />
      <TableTr td1="UKUPNO DOPRINOSI IZ PLAĆE" :td3="t6 ? t6 + month.valuta : ''" :bold="true" :indent="false" />

      <TableTr td1="DOHODAK - PLAĆA PRIJE OPOREZIVANJA" :td3="t7 ? t7 + month.valuta : ''" :bold="true" :indent="false" />

      <TableTr td1="OBRAĆUN POREZA" td3="OSNOVICA" :indent="false" />
      <TableTr td1="Osobni odbitak" td2="1.60" :td3="t8 ? t8 + month.valuta : ''" :indent="true" />
      <TableTr td1="Osnovica za oporezivanje" :td3="t9 ? t9 + month.valuta : ''" :indent="true" />
      <TableTr td1="Porez po stopi od" td2="20.00" :td3="(Math.round(t9 * 20) / 100) + month.valuta" :indent="true" />
      <TableTr td1="Porez po stopi od" td2="30.00" td3="0.00" :indent="true" />
      <TableTr td1="Prirez na porez" :td2="month.prirez + ''"
        :td3="Math.round(t9 * 0.2 * month.prirez) / 100 + month.valuta" />
      <TableTr td1="Ukupno porez i prirez" :td3="t10 + month.valuta" :bold="true" :indent="false" />

      <TableTr td1="PLAĆA NAKON OPOREZIVANJA" :td3="t11 + month.valuta" :bold="true" :indent="false" />

      <TableTr td1="NEOPOREZIVE NAKNADE I OSTALE ISPLATE" :td3="t12 + month.valuta" :indent="false" />
      <TableTr v-if="month.prijevoz != 0" td1="PRIJEVOZ" :td3="month.prijevoz + month.valuta" :indent="true" />
      <TableTr v-if="month.nagrada != 0" td1="!Nagrada" :td3="month.nagrada + month.valuta" :indent="true" />
      <TableTr v-if="month.prehrana != 0" td1="!Prehrana" :td3="month.prehrana + month.valuta" :indent="true" />
      <TableTr v-if="month.prigodna != 0" td1="!Prigodna" :td3="month.prigodna + month.valuta" :indent="true" />

      <TableTr td1="Za isplatu" :td3="t13 + month.valuta" :bold="true" :indent="false" />

      <TableTr td1="DOPRINOS NA PLAĆE" :indent="false" />
      <TableTr td1="zdrastveno" td2="16.50" :td3="Math.round(t4 * 16.5) / 100 + month.valuta" :indent="true" />
      <TableTr td1="UKUPNO DOPRINOSI NA PLAĆE" td2="16.50" :td3="Math.round(t4 * 16.5) / 100 + month.valuta"
        :indent="true" />

      <TableTr td1="UKUPNO BRUTTO, NAKNADE I DOPRINOSI NA PLAĆE"
        :td3="Math.round(t4 * 116.5 + t12 * 100) / 100 + month.valuta" :indent="true" />
    </tbody>
  </table>
</template>