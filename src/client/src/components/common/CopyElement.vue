<template>
  <div class="copy-container">
    <span @click="copy">
      <slot/>
    </span>
    <CIcon class="copy-icon" icon="cilCopy"/>
  </div>
</template>

<script>
import { copyText } from "vue3-clipboard";

export default {
  methods: {
    copy(event) {
      copyText(event.target.innerText, event.target, () => {});
    }
  }
}
</script>

<style scoped>
.copy-container {
  cursor: pointer;
  position: relative;
  margin-right: 10px;
}
.copy-container:hover .copy-icon {
  visibility: visible;
}
.copy-icon {
  visibility: hidden;
  position: absolute;
}
</style>
