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
              <div v-else>
                {{ item[key] }}
              </div>
            </slot>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import Btn from "@/components/Btn/Btn";
export default {
  name: 'Table',
  components: {Btn},
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
  max-width: 900px;
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
}

</style>
