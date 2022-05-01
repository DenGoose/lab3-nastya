<template>
  <Layout :title="id ? 'Редактирование записи' : 'Создание записи'">
    <LoansForm @submit="onSubmit" :id="id"  />
  </Layout>
</template>

<script>
import { useStore } from 'vuex';

import { updateLoansItem, addLoansItem } from '@/store/loans/selectors';
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
      onSubmit: (form) => form.id ? updateLoansItem(store, form) : addLoansItem(store, form )
    }
  }

}
</script>

