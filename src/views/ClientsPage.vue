<template>
  <Layout title="Клиенты">
    <ClientsList />
  </Layout>
</template>

<script>
import Layout from '@/components/Layout/Layout';
import ClientsList from '@/components/ClientsList/ClientsList';

export default {
  name: 'ClientsPage',
  components: {
    Layout,
    ClientsList,
  }
}
</script>
