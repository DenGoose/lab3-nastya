<template>
  <Layout title="Кредиты">
    <LoansList :client_id="client_id" />
  </Layout>
</template>

<script>
import Layout from '@/components/Layout/Layout';
import LoansList from '@/components/LoansList/LoansList';

export default {
  name: 'Loans',
  components: {
    Layout,
    LoansList,
  },
  props: {
    client_id: Number,
  }
}
</script>
