<template>
  <div :class="$style.root">
    <Table
        :headers="[
          {value: 'id', text: 'ID'},
          {value: 'name', text: 'ФИО'},
          {value: 'control', text: 'Действие'},
        ]"
        :items="items"
    >
      <template v-slot:control="{ item }">
        <Btn @click="onClickLoans(item.id)" theme="info">Показать</Btn>
        <Btn @click="onClickEdit(item.id)" theme="info">Изменить</Btn>
        <Btn @click="onClickRemove(item.id)" theme="danger">Удалить</Btn>
      </template>
    </Table>
    <RouterLink :to="{ name: 'ClientsEdit' }">
      <Btn :class="$style.create" theme="info">Создать</Btn>
    </RouterLink>
  </div>
</template>

<script>
import { useStore } from 'vuex';
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';

import { selectClientsItems, removeClientsItem, fetchClientsItems  } from '@/store/clients/selectors'
import Table from '@/components/Table/Table';
import Btn from '@/components/Btn/Btn';
export default {
  name: 'ClientsList',
  components: {
    Btn,
    Table,
  },
  setup() {
    const store = useStore();
    const router = useRouter();
    onMounted(() => {
      fetchClientsItems(store);
    });
    return {
      items: computed(() => selectClientsItems(store)),
      onClickRemove: id => {
        const isConfirmRemove = confirm('Вы действительно хотите удалить запись?')
        if (isConfirmRemove) {
          removeClientsItem(store, id)
        }
      },
      onClickEdit: ( id ) => {
        router.push({ name: 'ClientsEdit', params: { id } })
      },
      onClickLoans: (client_id) => {
        router.push({name: 'Loans', params: { filter_field: 'id_client', filter_id: client_id }})
      }
    }
  },
}
</script>

<style module lang="scss">
.root {
  .create {
    margin-top: 16px;
  }
}
</style>
