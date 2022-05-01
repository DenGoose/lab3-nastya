<template>
  <Layout title="Кредиты">
    <LoansList :filter_field="filter_field" :filter_id="filter_id" />
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
    filter_field: String,
    filter_id: Number,
  }
}
</script>
