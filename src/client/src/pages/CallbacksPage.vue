<template>
  <CRow>
    <CSpinner class="m-sm-auto" color="dark" v-if="isLoading" />
  </CRow>
  <CallbackItems
    :callbacks="callbacks"
    :dynamicTemplateVariables="dynamicTemplateVariables"
    @add="add"
    @update="update"
    @remove="remove"
    @changeOrder="changeOrder"
    v-if="!isLoading"
  />
</template>

<script>
import CallbackItems from "@/components/CallbackItems";
import { mapActions, mapState, mapMutations } from "vuex";

export default {
  components: {
    CallbackItems,
  },
  async mounted() {
    this.setStub(this.$route.params.stubId);
    await this.fetch();

    if (!this.dynamicTemplateVariables.length) {
      await this.fetchDynamicTemplateVariables();
    }
  },
  methods: {
    ...mapMutations({
      add: "callback/add",
      setStub: "callback/setRelationId",
    }),
    ...mapActions({
      fetch: "callback/fetch",
      fetchDynamicTemplateVariables: "callback/fetchDynamicTemplateVariables",
      update: "callback/save",
      remove: "callback/remove",
      changeOrder: "callback/changeOrder",
    }),
  },
  computed: {
    ...mapState({
      callbacks: (state) => state.callback.entities,
      dynamicTemplateVariables: (state) =>
        state.callback.dynamicTemplateVariables,
      isLoading: (state) => state.callback.isLoading,
    }),
  },
};
</script>
