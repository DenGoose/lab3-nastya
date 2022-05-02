<template>
  <div :class="$style.root">
    <Table
      :headers="[
        {value: 'id', text: 'ID', type: 'text'},
        {value: 'photo', text: 'Фотография', type: 'photo'},
        {value: 'loan_purpose', text: 'Цель кредита', type: 'text'},
        {value: 'manager_comment', text: 'Комментарий', type: 'text'},
        {value: 'loan_amount', text: 'Сумма кредита', type: 'text'},
        {value: 'client', text: 'Клиент', type: 'array', field: 'name'},
        {value: 'control', text: 'Действие', type: 'text'},
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
import {computed, onBeforeMount, onMounted} from 'vue';
import { useRouter } from 'vue-router';

import {selectLoansItems, removeLoansItem, fetchLoansItems, fetchLoansFilteredItems} from '@/store/loans/selectors';
import Table from '@/components/Table/Table';
import Btn from '@/components/Btn/Btn';

export default {
  name: 'LoansList',
  components: {
    Table,
    Btn,
  },
  props: {
    filter_field: String,
    filter_id: String,
  },
  setup(props) {
    const store = useStore();
    const router = useRouter();
    onBeforeMount(() => {
      !!(props.filter_id) ? fetchLoansFilteredItems(store, props.filter_field, props.filter_id.toString())  : fetchLoansItems(store);
    });
    return {
      items: computed(() => selectLoansItems(store)),
      onClickRemove: id => {
        const isConfirmRemove = confirm('Вы действительно хотите удалить запись?')
        if (isConfirmRemove) {
          removeLoansItem(store, id)
        }
      },
      onClickEdit: id => {
        router.push({ name: 'LoansEdit', params: { id: id }})
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
