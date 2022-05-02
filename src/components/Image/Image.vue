<template>
  <div class="image" :style="{width: width + 'px', height: height + 'px'}">
    <img class="image__photo" :src="photo" :alt="alt">
  </div>
</template>
<script>
export default {
  name: 'VImage',
  props: {
    photo: String,
    alt: String,
    width: Number,
    height: Number,
  },
  setup(props) {

  }
}
</script>

<style lang="scss" scoped>
.image {
  width: 100px;
  height: 100px;
  position: relative;
  .image__photo {
    top: 0;
    left: 0;
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: contain;
  }
}
</style>