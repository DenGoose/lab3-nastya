<template>
  <div :class="$style.root">
    <table v-if="items.length" :class="$style.table">
      <thead :class="$style.head">
        <tr :class="$style.row">
          <th v-for="{ value, text } in headers" :key="value">
            {{ text }}
          </th>
      </tr>
      </thead>
      <tbody :class="$style.body">
        <tr v-for="(item, index, type) in items" :key="index">
          <td v-for="(key, idx) in colKeys" :key="idx">
            <slot :name="key" v-bind="{ item }">
               <div v-if="'array' ===  colTypes[idx]">
                {{ item[key][headers[idx].field] }} ({{ item[key].id }})
              </div>
              <div v-else-if="'photo' ===  colTypes[idx]" :class="$style.photo">
                <v-image
                    :photo="'' + item[key]"
                    :alt="'Фото'"
                />
              </div>
              <div v-else>
                {{ item[key] }}
              </div>
            </slot>
          </td>
        </tr>
      </tbody>
    </table>
    <div v-else :class="[$style.message, $style.message_error]">
      <span>Элементов не найдено</span>
    </div>
  </div>
</template>

<script>
import Btn from "@/components/Btn/Btn";
import VImage from "@/components/Image/Image";
export default {
  name: 'Table',
  components: {VImage, Btn},
  props: {
    items: Array,
    headers: Array,
  },
  computed: {
    colKeys() {
      return this.headers.map(({ value }) => value);
    },
    colTypes() {
      return this.headers.map(({type}) => type);
    },
  }
}
</script>

<style module lang="scss">
.root {
  .table {
    width: 100%;
    border-collapse: collapse;
    th, td {
      padding: 10px;
      text-align: center;
    }

    th {
      border-bottom: 1px solid black;
    }
  }
  .head {
  }
  .message {
    display: flex;
    width: 100%;
    padding: 10px;
    border-radius: 3px;
    &.message_error {
      background-color: #f8d7da;
      color: #881c59;
    }
  }
}

</style>
