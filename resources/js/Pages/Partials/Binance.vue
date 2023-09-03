<script setup lang="ts">
import Btn from '@/Components/Btn.vue';
import { useForm } from '@inertiajs/vue3';

interface Coin {
  id: number;
  coin: string;
  depositAllEnable: boolean;
  withdrawAllEnable: boolean;
  name: string;
  free: number;
  locked: number;
  freeze: number;
  withdrawing: number;
  ipoing: number;
  ipoable: number;
  storage: number;
  isLegalMoney: boolean;
  trading: boolean;
  all: number;
  price: number;
  lending: number;
  earnF: number;
  earnL: number;
}
defineProps<{
  binance: [Array<Coin>, number, Array<boolean>];
}>();

const formSELP = useForm({
  earn: 'SELP',
});

const updateSELP = () => {
  formSELP.post(route('earn.update'), {
    preserveScroll: true,
    onError: () => console.log('error'),
    onFinish: () => { formSELP.reset(); formSELP.clearErrors(); },
  });
};

const formSELL = useForm({
  earn: 'SELL',
});

const updateSELL = () => {
  formSELL.post(route('earn.update'), {
    preserveScroll: true,
    onError: () => console.log('error'),
    onFinish: () => { formSELL.reset(); formSELL.clearErrors(); },
  });
};

const formSEFP = useForm({
  earn: 'SEFP',
});

const updateSEFP = () => {
  formSEFP.post(route('earn.update'), {
    preserveScroll: true,
    onError: () => console.log('error'),
    onFinish: () => { formSEFP.reset(); formSEFP.clearErrors(); },
  });
};

const formSEFL = useForm({
  earn: 'SEFL',
});

const updateSEFL = () => {
  formSEFL.post(route('earn.update'), {
    preserveScroll: true,
    onError: () => console.log('error'),
    onFinish: () => { formSEFL.reset(); formSEFL.clearErrors(); },
  });
};

const formGetAll = useForm({
  getAll: 'all',
});

const getAll = () => {
  formGetAll.post(route('coin.update'), {
    preserveScroll: true,
    onError: () => console.log('error'),
    onFinish: () => { formSEFL.reset(); formSEFL.clearErrors(); },
  });
};

const formSymbols = useForm({
  getAll: 'all',
});

const symbols = () => {
  formSymbols.post(route('symbol.update'), {
    preserveScroll: true,
    onError: () => console.log('error'),
    onFinish: () => { formSEFL.reset(); formSEFL.clearErrors(); },
  });
};
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Binance</h2>
      <Btn @click="getAll">update Coins</Btn>
      <Btn @click="updateSELP">update SELP</Btn>
      <Btn @click="updateSELL">update SELL</Btn>
      <Btn @click="updateSEFP">update SEFP</Btn>
      <Btn @click="updateSEFL">update SEFL</Btn>
      <Btn @click="symbols">update Symbols</Btn>
    </header>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <table class="table-auto w-full">
          <thead>
            <tr>
              <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">Name</th>
              <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">All</th>
              <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">Price</th>
              <th v-if="binance[2][0]" class="mt-1 text-sm text-gray-600 dark:text-gray-400">Free</th>
              <th v-if="binance[2][1]" class="mt-1 text-sm text-gray-600 dark:text-gray-400">Locked</th>
              <th v-if="binance[2][2]" class="mt-1 text-sm text-gray-600 dark:text-gray-400">Freeze</th>
              <th v-if="binance[2][3]" class="mt-1 text-sm text-gray-600 dark:text-gray-400">Withdrawing</th>
              <th v-if="binance[2][4]" class="mt-1 text-sm text-gray-600 dark:text-gray-400">Ipoing</th>
              <th v-if="binance[2][5]" class="mt-1 text-sm text-gray-600 dark:text-gray-400">Ipoable</th>
              <th v-if="binance[2][6]" class="mt-1 text-sm text-gray-600 dark:text-gray-400">Storage</th>
              <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">Lending</th>
              <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">EarnF</th>
              <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">EarnL</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(coin, i) in binance[0]" :key="coin.id">
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ coin.name }}</td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ coin.all + ' ' + coin.coin }}</td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ coin.all * coin.price }} € </td>
              <td v-if="binance[2][0]" class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ coin.free }}</td>
              <td v-if="binance[2][1]" class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ coin.locked }}</td>
              <td v-if="binance[2][2]" class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ coin.freeze }}</td>
              <td v-if="binance[2][3]" class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ coin.withdrawing }}</td>
              <td v-if="binance[2][4]" class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ coin.ipoing }}</td>
              <td v-if="binance[2][5]" class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ coin.ipoable }}</td>
              <td v-if="binance[2][6]" class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ coin.storage }}</td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ coin.lending }}</td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ coin.earnF }}</td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ coin.earnL }}</td>
            </tr>
            <tr>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">Sum</td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ binance[1] }} €</td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ binance[1] * 7.5345 }} kn</td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
              <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</template>
