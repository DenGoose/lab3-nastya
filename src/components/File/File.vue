<template>
  <div class="file">
    <div class="file__label">
      <label :for="name">{{ title }}</label>
    </div>
    <div class="file__body">
      <div class="file__control">
        <div class="file__choose">
          <div class="file__name">
            <span v-if="value">{{value.replace('/files/', '')}}</span>
            <span v-else>Файл не выбран</span>
          </div>
          <input @input="previewFiles" class="file__input"  :id="name" :placeholder="placeholder" type="file" ref="fileInput">
        </div>
        <div class="file__clear-button">
          <a @click="clearFile">
            <span>&#10006;</span>
          </a>
        </div>
      </div>
      <div class="file__preview">
        <VImage
            :photo="previewPhoto"
            :alt="'Превью фота'"
        />
      </div>
    </div>
  </div>
</template>

<script>
import {computed, onBeforeMount, ref, watchEffect} from "vue";
import VImage from "@/components/Image/Image";
export default {
  name: 'VFile',
  components: {VImage},
  props: {
    title: String,
    name: String,
    placeholder: String,
    value: String,
  },
  setup(props, context) {
    let originFile = props.value;
    const fileInput = ref(null);
    const previewPhoto = ref('https://guselnikov.ivsand.ru')
    watchEffect(() => {
      if (previewPhoto.value === 'https://guselnikov.ivsand.ru')
        previewPhoto.value = 'https://guselnikov.ivsand.ru' + props.value;
    })
    function previewFiles(e) {
      if (e.target.files[0]) {
        previewPhoto.value = URL.createObjectURL(e.target.files[0])
        context.emit('changeFile', e);
      }
      else
        clearFile();
    }

    function clearFile() {
      console.log(originFile)
      fileInput.value.value = '';
      previewPhoto.value = null;
      context.emit('clear', 'true');
    }
    return {
      previewFiles,
      clearFile,
      fileInput,
      previewPhoto,
    }
  }
}
</script>

<style lang="scss" scoped>
.file {
  position: relative;
  display: flex;
  align-items: center;
  flex: 1 1 100%;
  &>*:not(:last-child) {
    margin-right: 5px;
  }

  .file__label {
    flex: 0 0 150px;
  }

  .file__body {
    display: flex;
    flex-direction: column;
    flex: 1 1 100%;
    &>*:not(:last-child) {
      margin-bottom: 5px;
    }
  }

  .file__control {
    display: flex;
    &>*:not(:last-child) {
      margin-right: 5px;
    }
  }

  .file__choose {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    &>*:not(:last-child) {
      margin-bottom: 5px;
    }
  }

  .file__input {
    display: block;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
  }

  .file__clear-button {
    display: flex;
    background-color: #de0101;
    color: white;
    border-radius: 3px;
    align-self: end;
    a {
      cursor: pointer;
      padding: 8px;

    }
  }

  .file__preview {

  }
}

</style>