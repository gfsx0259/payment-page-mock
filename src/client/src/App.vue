<template>
  <div class="app">
    <NavBar />
    <CContainer class="mt-4">
      <router-view />
    </CContainer>
  </div>
</template>

<script>
import "@coreui/coreui/dist/css/coreui.min.css";
import "snackbar-vue/dist/snackbar-vue.common.css";

import NavBar from "@/components/common/NavBar";
import { useSnackbarPlugin } from "snackbar-vue";

export default {
  components: {
    NavBar,
  },
  mounted() {
    this.snack = useSnackbarPlugin();
  },
  watch: {
    "$store.state.message"(message) {
      this.snack.show({
        text: message.text,
      });
    },
  },
};
</script>

<style>
:root {
  --cui-header-border-width: 0;
}
</style>
