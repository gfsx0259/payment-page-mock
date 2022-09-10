<template>
  <CRow>
    <CSpinner class="m-sm-auto" color="dark" v-if="isLoading" />
  </CRow>
  <ModalWindow :title="title" :saveCallback="save" v-model:visible="visible">
    <StubForm :route-id="this.$route.params.id" />
  </ModalWindow>
  <CRow v-if="!isLoading">
    <div class="d-flex justify-content-start mb-4">
      <CButton color="light" @click="createFormShow">Add stub</CButton>
    </div>

    <StubItems
      :stubs="stubs"
      :routeId="routeId"
      @setDefault="changeDefault"
      @remove="remove($event)"
      @edit="editFormShow($event)"
    />
  </CRow>
</template>

<script>
import ModalWindow from "@/components/common/ModalWindow";
import StubItems from "@/components/StubItems";
import StubForm from "@/components/StubForm";
import { mapState, mapActions, mapMutations } from "vuex";

export default {
  components: {
    StubForm,
    ModalWindow,
    StubItems,
  },
  data() {
    return {
      title: "",
      visible: false,
    };
  },
  mounted() {
    this.setRoute(parseInt(this.$route.params.routeId));
    this.fetch();
  },
  methods: {
    ...mapMutations({
      setRoute: "stub/setRelationId",
      setDefault: "stub/setDefault",
      loadFormData: "stub/loadFormByStub",
      cleanFormData: "stub/cleanForm",
    }),
    ...mapActions({
      fetch: "stub/fetch",
      save: "stub/save",
      saveDefault: "stub/saveDefault",
      remove: "stub/remove",
    }),
    showForm() {
      this.visible = true;
    },
    changeDefault(id) {
      this.setDefault(id);
      this.saveDefault();
    },
    editFormShow(id) {
      this.title = "Edit stub";

      this.loadFormData(id);
      this.showForm();
    },
    createFormShow() {
      this.title = "Create stub";

      this.cleanFormData();
      this.showForm();
    },
  },
  computed: {
    ...mapState({
      stubs: (state) => state.stub.entities,
      routeId: (state) => state.stub.relationId,
      isLoading: (state) => state.stub.isLoading,
    }),
  },
};
</script>
