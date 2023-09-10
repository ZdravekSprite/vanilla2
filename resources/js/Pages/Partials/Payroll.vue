<script setup lang="ts">
import TableTr from '@/Components/TableTr.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
  month: {
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
const t2 = props.month.stimulacija;
const t3 = props.month.prijevoz + props.month.regres;
const t5 = Math.round((props.month.v01 + props.month.v02 + props.month.v03 + props.month.v04 + props.month.v05 + props.month.v06 + props.month.v07 + props.month.v08 + props.month.v09 + props.month.v10 + props.month.v11 + props.month.v12 + props.month.v13 + props.month.stimulacija) * 100) / 100;
const t4 = t5 + t3;
const t7 = t5 - Math.round(t5 * 15) / 100 - Math.round(t5 * 5) / 100;
const t8 = t7 - props.month.odbitak > 0 ? props.month.odbitak : t7;
const t9 = Math.round((t7 - t8) * 100) / 100;
const t10 = Math.round(t9 * (1 + props.month.prirez / 100) * 20) / 100;;
const t11 = Math.round((t7 - t10) * 100) / 100;
const t12 = t3;
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
      <TableTr v-if="month.h01 != 0" td1="1.1. Za redoviti rad" :td2="month.h01 + ''" :td3="month.v01 + month.valuta" />
      <TableTr v-if="month.h09 != 0" td1="1.4 Za prekovremeni rad" :td2="month.h09 + ''"
        :td3="month.v09 + month.valuta" />
      <TableTr v-if="month.h12 != 0" td1="1.7a Praznici. Blagdani, izbori" :td2="month.h12 + ''"
        :td3="month.v12 + month.valuta" />
      <TableTr v-if="month.h10 != 0" td1="1.7b Godišnji odmor" :td2="month.h10 + ''" :td3="month.v10 + month.valuta" />
      <TableTr v-if="month.h13 != 0" td1="1.7c Plaćeni dopust" :td2="month.h13 + ''" :td3="month.v13 + month.valuta" />
      <TableTr v-if="month.h11 != 0" td1="1.7d Bolovanje do 42 dana" :td2="month.h11 + ''"
        :td3="month.v11 + month.valuta" />
      <TableTr v-if="month.h03 != 0" td1="1.7e Dodatak za rad nedjeljom" :td2="month.h03 + ''"
        :td3="month.v03 + month.valuta" />
      <TableTr v-if="month.h05 != 0" td1="1.7f Dodatak za rad na praznik" :td2="month.h05 + ''"
        :td3="month.v05 + month.valuta" />
      <TableTr v-if="month.h02 != 0" td1="1.7g Dodatak za noćni rad" :td2="month.h02 + ''"
        :td3="month.v02 + month.valuta" />
      <TableTr td1="1.7.P Nagrada za radne rezultate" td3="_" />

      <TableTr
        td1="2. OSTALI OBLICI RADA TEMELJEM KOJIH OSTVARUJE PRAVO NA UVEĆANJE PLAĆE PREMA KOLEKTIVNOM UGOVORU, PRAVILNIKU O RADU ILI UGOVORU O RADU I NOVČANI IZNOS PO TOJ OSNOVI (SATI PRIPRAVNOSTI)"
        :td3="t2 ? t2 + month.valuta : ''" :indent="false" />
      <TableTr v-if="month.stimulacija != 0" td1="2.8. Stimulacija bruto" :td3="month.stimulacija + month.valuta" />

      <TableTr td1="3. PROPISANI ILI UGOVORENI DODACI NA PLAĆU RADNIKA I NOVČANI IZNOSI PO TOJ OSNOVI" td2=""
        :td3="t3 ? t3 + month.valuta : ''" :indent="false" />
      <TableTr v-if="month.prijevoz != 0" td1="3.1. Prijevoz" :td3="month.prijevoz + month.valuta" />
      <TableTr v-if="month.regres != 0" td1="3.7. Regres za godišnji odmor" :td3="month.regres + month.valuta" />

      <TableTr td1="4. ZBROJENI IZNOSI PRIMITAKA PO SVIM OSNOVAMA PO STAVKAMA 1. DO 3." :td3="t4 ? t4 + month.valuta : ''"
        :indent="false" />

      <TableTr td1="5. OSNOVICA ZA OBRAČUN DOPRINOSA" :td3="t5 ? t5 + month.valuta : ''" :bold="true" :indent="false" />

      <TableTr td1="6. VRSTE I IZNOSI DOPRINOSA ZA OBVEZNA OSIGURANJA KOJA SE OBUSTAVLJAJU IZ PLAĆ" :indent="false" />
      <TableTr td1="6.1. za mirovinsko osiguranje na temelju generacijske solidarnosti (I. STUP)"
        :td3="(Math.round(t5 * 15) / 100) + month.valuta" />
      <TableTr td1="6.2 za mirovinsko osiguranje na temelju individualne kapitalizirane štednje (II. STUP)"
        :td3="(Math.round(t5 * 5) / 100) + month.valuta" />

      <TableTr td1="7. DOHODAK" :td3="t7 ? t7 + month.valuta : ''" :bold="true" :indent="false" />

      <TableTr :td1="'8. OSOBNI ODBITAK 1.00 / ' + month.odbitak" :td3="t8 ? t8 + month.valuta : ''" :indent="false" />

      <TableTr td1="9. POREZNA OSNOVICA" :td3="t9 ? t9 + month.valuta : ''" :indent="false" />

      <TableTr td1="10. IZNOS PREDUJMA POREZA I PRIREZA POREZU NA DOHODAK" :td3="t10 + month.valuta" :indent="false" />
      <TableTr v-if="t9 != 0" :td1="'20.00% ' + t9" :td3="Math.round(t9 * 20) / 100 + month.valuta" />
      <TableTr :td1="'Prirez ' + month.prirez + ' %'" :td3="Math.round(t9 * 0.2 * month.prirez) / 100 + month.valuta" />

      <TableTr td1="11. NETO PLAĆA" :td3="t11 ? t11 + month.valuta : ''" :bold="true" :indent="false" />

      <TableTr td1="12. NAKNADE UKUPNO" :td3="t12 ? t12 + month.valuta : ''" :indent="false" />

      <TableTr td1="13. NETO + NAKNADE" :td3="t13 ? t13 + month.valuta : ''" :bold="true" :indent="false" />

      <TableTr td1="14. OBUSTAVE UKUPNO" :td3="t14 ? t14 + month.valuta : ''" :indent="false" />

      <TableTr td1="15. IZNOS PLAĆE/NAKNADE PLAĆE ISPLAĆEN RADNIKU NA REDOVAN RAČUN" :td3="t15 ? t15 + month.valuta : ''"
        :bold="true" :indent="false" />

      <TableTr td1="17.5. vrsta i iznos obustave" :indent="false" />
      <TableTr v-if="month.sindikat != 0" td1="Sindikalna članarina" :td3="month.sindikat + month.valuta" />
      <TableTr v-if="month.kredit != 0" td1="Kredit" :td3="month.kredit + month.valuta" />
    </tbody>
  </table>
</template>