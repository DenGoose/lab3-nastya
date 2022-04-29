<template>
  <Layout :title="id ? 'Редактирование записи' : 'Создание записи'">
    <ClientsForm
        :id="id"
        @submit="onSubmit"
    />
  </Layout>
</template>

<script>
import { useStore } from 'vuex';

import { updateItem, addItem } from '@/store/clients/selectors';
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
    const store = useStore();
    return {
      onSubmit: ({ id, name }) => id ?
          updateItem(store, { id, name }) :
          addItem(store, { name }),
    };
  }
}
</script>

