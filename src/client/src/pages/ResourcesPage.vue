<template>
  <CRow>
    <CSpinner class="m-sm-auto" color="dark" v-if="isLoading" />
  </CRow>
  <ModalWindow v-model:visible="visible" :title="title" :saveCallback="save">
    <ResourceForm />
  </ModalWindow>
  <CRow v-if="!isLoading">
    <div class="d-flex justify-content-start mb-4">
      <CButton color="light" @click="createFormShow">Add resource</CButton>
    </div>

    <ResourceItems
      :resources="resources"
      @edit="editFormShow($event)"
      @remove="remove($event)"
      @setDefault="changeDefault"
    ></ResourceItems>
  </CRow>
</template>

<script>
import { mapActions, mapState, mapMutations } from "vuex";
import ModalWindow from "@/components/common/ModalWindow";
import ResourceItems from "@/components/ResourceItems";
import ResourceForm from "@/components/ResourceForm";

export default {
  components: {
    ResourceItems,
    ResourceForm,
    ModalWindow,
  },
  data() {
    return {
      title: "",
      visible: false,
    };
  },
  async mounted() {
    await this.fetch();
  },
  methods: {
    ...mapActions({
      fetch: "resource/fetch",
      saveDefault: "resource/saveDefault",
      save: "resource/save",
      remove: "resource/remove",
    }),
    ...mapMutations({
      loadFormByResource: "resource/loadFormByResource",
      cleanForm: "resource/cleanForm",
      setDefault: "resource/setDefault",
    }),
    changeDefault(id) {
      this.setDefault(id);
      this.saveDefault(id);
    },
    createFormShow() {
      this.title = "Create resource";

      this.cleanForm();

      this.visible = true;
    },
    editFormShow(id) {
      this.title = "Edit resource";

      this.loadFormByResource(id);

      this.visible = true;
    },
  },
  computed: {
    ...mapState({
      resources: (state) => state.resource.entities,
      isLoading: (state) => state.resource.isLoading,
      invalidFormFields: (state) => state.resource.invalidFormFields,
    }),
  },
};
</script>
