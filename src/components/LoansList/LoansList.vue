<template>
  <div :class="$style.root">
    <Table
      :headers="[
        {value: 'id', text: 'ID'},
        {value: 'photo', text: 'Фотография'},
        {value: 'loan_purpose', text: 'Цель кредитап'},
        {value: 'manager_comment', text: 'Комментарий'},
        {value: 'loan_amount', text: 'Сумма кредита'},
        {value: 'id_client', text: 'ID клиента'},
        {value: 'control', text: 'Действие'},
      ]"
      :items="items"
    >
      <template v-slot:control="{ item }">
        <Btn @click="onClickEdit(item.id)" theme="info">Изменить</Btn>
        <Btn @click="onClickRemove(item.id)" theme="danger">Удалить</Btn>
      </template>
    </Table>
    <router-link :to="{ name: 'LoansEdit' }">
      <Btn :class="$style.create" theme="info">Создать</Btn>
    </router-link>
  </div>
</template>

<script>
import { useStore } from 'vuex';
import { computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';

import {selectItems, removeItem, fetchItems, selectSortItems, fetchSortedItems} from '@/store/loans/selectors';
import Table from '@/components/Table/Table';
import Btn from '@/components/Btn/Btn';

export default {
  name: 'LoansList',
  components: {
    Table,
    Btn,
  },
  props: {
    client_id: Number,
  },
  setup(props) {
    const store = useStore();
    const router = useRouter();
    onMounted(() => {
      !!(props.client_id) ? fetchSortedItems(store)  : fetchItems(store);
    });
    return {
      items: computed(() => !!(props.client_id) ? selectSortItems(store, props.client_id) : selectItems(store)),
      onClickRemove: id => {
        const isConfirmRemove = confirm('Вы действительно хотите удалить запись?')
        if (isConfirmRemove) {
          removeItem(store, id)
        }
      },
      onClickEdit: id => {
        router.push({ name: 'LoansEdit', params: { id } })
      }
    }
  }

}
</script>

<style module lang="scss">
.root {

  .create {
    margin-top: 16px;
  }

}
</style>
