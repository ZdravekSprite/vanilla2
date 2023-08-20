<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NewForm from '@/Components/NewForm.vue';
import FileForm from '@/Components/FileForm.vue';
import EditForm from '@/Components/EditForm.vue';
import DeleteForm from '@/Components/DeleteForm.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps<{
  roles: Array<{
    id: number;
    name: String;
    description: String;
  }>;
}>();
</script>

<template>
  <Head title="Roles" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <h2 class="p-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Roles</h2>
        <FileForm fileName="roles.csv" link="import" model="user" title="Import" class="p-1" />
        <FileForm fileName="users.csv" link="export" model="user" title="Export" class="p-1" />
        <NewForm :storeRoute="'role.store'" :labels="[['name'], ['description']]" class="p-1" />
      </div>
    </template>

    <div class="py-12 space-y-4">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <table v-if="roles" class="table-auto w-full">
              <caption class="caption-top">
                Roles!
              </caption>
              <thead class="text-lg font-medium text-gray-900 dark:text-gray-100">
                <tr>
                  <th>name</th>
                  <th>description</th>
                  <th class="w-32">actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(e, i) in roles" :key="e.id">
                  <td>{{ e['name'] }}</td>
                  <td>{{ e['description'] }}</td>
                  <td>
                    <EditForm class="float-left" :element="e" updateRoute="role.update"
                      :labels="[['name'], ['description']]" />
                    <DeleteForm class="float-right" :element="e" destroyRoute="role.destroy" />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>