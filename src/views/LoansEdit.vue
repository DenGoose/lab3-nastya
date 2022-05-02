<template>
  <Layout :title="id ? 'Редактирование записи' : 'Создание записи'">
    <LoansForm :id="id"/>
  </Layout>
</template>
<script>

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

  }

}
</script>

