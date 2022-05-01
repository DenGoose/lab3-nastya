<template>
  <div :class="$style.root">
    <div v-if="form.id" :class="$style.item">
      <div :class="$style.label">
        <label for="id">ID</label>
      </div>
      <input v-model="form.id" disabled :class="$style.input"  id="id" placeholder="id" type="text">
    </div>
    <div :class="$style.item">
      <div :class="$style.label">
        <label for="photo">Фотография</label>
      </div>
      <input @change="previewFiles" :class="$style.input"  id="photo" placeholder="Фотография" type="file">
    </div>
    <div :class="$style.item">
      <div :class="$style.label">
        <label for="loan_purpose">Цель кредита</label>
      </div>
      <input v-model="form.loan_purpose" :class="$style.input"  id="loan_purpose" placeholder="Цель кредита" type="text">
    </div>
    <div :class="$style.item">
      <div :class="$style.label">
        <label for="manager_comment">Комментарий</label>
      </div>
      <input v-model="form.manager_comment" :class="$style.input"  id="manager_comment" placeholder="Комментарий" type="text">
    </div>
    <div :class="$style.item">
      <div :class="$style.label">
        <label for="loan_amount">Сумма кредита</label>
      </div>
      <input v-model="form.loan_amount" :class="$style.input"  id="loan_amount" placeholder="Сумма кредита" type="text">
    </div>
    <div :class="$style.item">
      <div :class="$style.label">
        <label for="id_client">ID клиента</label>
      </div>
      <Select
          v-model="form.client.id"
          :class="$style.select"
          name="id_client" id="id_client"
          :selectID="form.client.id"
          :list="clientsList"
          :list-field="'name'"
      ></Select>
    </div>
    <div :class="$style.item">
      <Btn @click="onClick" :disabled="!isValidForm" theme="info">Сохранить</Btn>
    </div>
  </div>
</template>

<script>
import {computed, onBeforeMount, reactive, ref, watchEffect} from 'vue';
import {useStore} from 'vuex';
import {useRouter} from 'vue-router';

import {fetchLoansItems, selectLoansItemById} from '@/store/loans/selectors';
import {fetchUploadFiles, selectUploadFiles} from "@/store/files/selectors";

import Btn from '@/components/Btn/Btn';
import Select from "@/components/Select/Select";
import {selectClientsItems} from "@/store/clients/selectors";

export default {
  name: 'LoansForm',
  props: {
    id: { type: String, default: '' },
  },
  components: {
    Select,
    Btn,
  },
  setup(props, context) {
    const store = useStore();
    const router = useRouter();
    const form = reactive({
      id: '',
      photo: '',
      loan_purpose: '',
      manager_comment: '',
      loan_amount: '',
      client:  {
        id: '',
        name: '',
      },
    });
    const fileData = ref('');
    onBeforeMount(() => {
      fetchLoansItems(store);
    });

    watchEffect(() => {
      const loan = selectLoansItemById( store,  props.id );
      Object.keys(loan).forEach(key => {
        form[key] = loan[key];
      })
    });

    const isValidForm = computed(() => {
      for (const [key, value] of Object.entries(form))
        if (key !== 'id' && !(value)) return false;
      return true
    });

    async function uploadFile() {
      const res = await fetchUploadFiles(store, fileData.value);
      const file = await selectUploadFiles(store);
      return file;
    }

    return {
      form,
      isValidForm,
      clientsList: computed(() => selectClientsItems(store)),
      previewFiles: (e) => {
        fileData.value = e.target.files[0];
        form[`${e.target.id}`] = `${e.target.files[0].name}`;
        },
      fileData,
      onClick: async () => {
        const file = await uploadFile().then((response) => {
          return {...response}
        });
        if (file.file_path) {
          form.photo = file.file_path;
          context.emit('submit', form);
          await router.push({name: 'Loans'})
        }
      }
    }
  },
}
</script>

<style module lang="scss">
.root {
  padding-top: 30px;
  max-width: 900px;

  .item {
    display: flex;
    align-items: center;

    & + .item {
      margin-top: 15px;
    }
  }

  .label {
    flex: 0 0 150px
  }

  .input {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
  }

  .select {
    display: block;
    width: 100%;
    padding: 0.375rem 2.25rem 0.375rem 0.75rem;
    -moz-padding-start: calc(0.75rem - 3px);
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    appearance: none;
  }
}
</style>
