<template>
  <select v-model="selected" :class="$style.root">
    <option v-for="(value, key) in list" :key="key" :value="key" >
      {{ value }}
    </option>
  </select>
</template>

<script>
import {ref} from "vue";

export default {
  name: 'Select',
  props: {
    list: Array,
    selectID: Number
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
