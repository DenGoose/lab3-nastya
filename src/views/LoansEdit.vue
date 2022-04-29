<template>
  <Layout :title="id ? 'Редактирование записи' : 'Создание записи'">
    <LoansForm @submit="onSubmit" :id="id"  />
  </Layout>
</template>

<script>
import { useStore } from 'vuex';

import { updateItem, addItem } from '@/store/loans/selectors';
import LoansForm from '@/components/LoansForm/LoansForm';
import Layout from '@/components/Layout/Layout';

export default {
  name: 'LoansEdit',
  props: {
    id: String,
  },
  components: {
    Layout,
    LoansForm,
  },
  setup() {
    const store = useStore();
    return {
      onSubmit: ({ id, photo, loan_purpose, manager_comment, loan_amount, id_client }) => id ?
          updateItem(store, { id, photo, loan_purpose, manager_comment, loan_amount, id_client }) :
          addItem(store, { photo, loan_purpose, manager_comment, loan_amount, id_client } )
    }
  }

}
</script>

