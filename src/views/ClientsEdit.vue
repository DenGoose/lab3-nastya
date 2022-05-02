<template>
  <Layout :title="id ? 'Редактирование записи' : 'Создание записи'">
    <ClientsForm
        :id="id"
    />
  </Layout>
</template>

<script>
import { useStore } from 'vuex';

import { updateClientsItem, addClientsItem } from '@/store/clients/selectors';
import Layout from '@/components/Layout/Layout';
import ClientsForm from '@/components/ClientsForm/ClientsForm';
export default {
  name: 'ClientsEdit',
  props: {
    id: String,
  },
  components: {
    Layout,
    ClientsForm,
  },
  setup() {
  }
}
</script>

