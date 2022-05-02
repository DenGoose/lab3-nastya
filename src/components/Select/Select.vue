<template>
  <select v-model="selected" :class="$style.root">
    <option v-for="item in list" :key="item.id" :value="item.id" >
      {{ item[listField] }}
    </option>
  </select>
</template>

<script>
import {ref} from "vue";

export default {
  name: 'Select',
  props: {
    list: Array,
    selectID: String | Number,
    listField: String,
  },
  setup (props, { emit }) {
    const selected = ref(props.selectID);
    return {
      selected,
    }
  }
}
</script>

<style module lang="scss">
.root {

}
</style>
