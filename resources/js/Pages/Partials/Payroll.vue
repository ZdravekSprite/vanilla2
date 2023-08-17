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
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">1.1. Za redoviti rad</td>
        <td class="w-1/8 border p-2 text-center">___</td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">1.4 Za prekovremeni rad</td>
        <td class="w-1/8 border p-2 text-center">___</td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">1.7a Praznici. Blagdani, izbori</td>
        <td class="w-1/8 border p-2 text-center">___</td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">1.7b Godišnji odmor</td>
        <td class="w-1/8 border p-2 text-center">___</td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">1.7c Plaćeni dopust</td>
        <td class="w-1/8 border p-2 text-center">___</td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">1.7d Bolovanje do 42 dana</td>
        <td class="w-1/8 border p-2 text-center">___</td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">1.7e Dodatak za rad nedjeljom</td>
        <td class="w-1/8 border p-2 text-center">___</td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">1.7f Dodatak za rad na praznik</td>
        <td class="w-1/8 border p-2 text-center">___</td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">1.7g Dodatak za noćni rad</td>
        <td class="w-1/8 border p-2 text-center">___</td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
      <tr>
        <td class="w-3/4 border p-2 pl-6" colspan="2">1.7.P Nagrada za radne rezultate</td>
        <td class="w-1/8 border p-2 text-center"></td>
        <td class="w-1/8 border p-2 text-right">___</td>
      </tr>
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