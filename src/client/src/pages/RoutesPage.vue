<template>
  <ModalWindow :title="title" v-model:visible="visible" :saveCallback="create">
    <RouteForm />
  </ModalWindow>
  <div class="d-flex justify-content-start mb-4">
    <CButton color="light" @click="createFormShow">Add route</CButton>
  </div>
  <RouteItems
    :routes="searchedRoutes"
    @remove="remove($event)"
    @edit="editFormShow($event)"
    v-if="!isLoading"
  />
  <RoutePlaceholder v-if="isLoading" />
</template>

<script>
import ModalWindow from "@/components/common/ModalWindow";
import RouteItems from "@/components/RouteItems";
import RoutePlaceholder from "@/components/RoutePlaceholder";
import RouteForm from "@/components/RouteForm";
import { mapActions, mapMutations, mapState } from "vuex";

export default {
  components: {
    RouteForm,
    RoutePlaceholder,
    RouteItems,
    ModalWindow,
  },
  data() {
    return {
      title: "",
      visible: false,
    };
  },
  methods: {
    ...mapMutations({
      loadForm: "route/loadForm",
      clean: "route/clean",
    }),
    ...mapActions({
      fetch: "route/fetch",
      create: "route/save",
      remove: "route/remove",
    }),
    createFormShow() {
      this.title = "Create route";

      this.clean();
      this.visible = true;
    },
    editFormShow(id) {
      this.title = "Edit route";

      this.loadForm(id);
      this.visible = true;
    },
  },
  mounted() {
    this.fetch();
  },
  computed: {
    ...mapState({
      routes: (state) => state.route.entities,
      isLoading: (state) => state.route.isLoading,
      searchQuery: (state) => state.route.searchQuery,
    }),
    searchedRoutes() {
      return this.routes.filter((route) =>
        route.path.includes(this.searchQuery)
      );
    },
  },
};
</script>

<style>
.card {
  align-items: center;
}
.card img {
  height: 110px;
  max-width: 12rem;
}
.card-body {
  width: 100%;
  padding: 1rem 2rem;
}
</style>
