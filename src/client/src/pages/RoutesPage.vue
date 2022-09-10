<template>
  <ModalWindow
    title="Create route"
    v-model:visible="visible"
    :saveCallback="create"
  >
    <RouteForm />
  </ModalWindow>
  <div class="d-flex justify-content-start mb-4">
    <CButton color="light" @click="showForm">Add route</CButton>
  </div>
  <RouteItems
    :routes="searchedRoutes"
    @remove="remove($event)"
    v-if="!isLoading"
  />
  <RoutePlaceholder v-if="isLoading" />
</template>

<script>
import ModalWindow from "@/components/common/ModalWindow";
import RouteItems from "@/components/RouteItems";
import RoutePlaceholder from "@/components/RoutePlaceholder";
import RouteForm from "@/components/RouteForm";
import { mapActions, mapState } from "vuex";

export default {
  components: {
    RouteForm,
    RoutePlaceholder,
    RouteItems,
    ModalWindow,
  },
  data() {
    return {
      visible: false,
    };
  },
  methods: {
    ...mapActions({
      fetch: "route/fetch",
      create: "route/save",
      remove: "route/remove",
    }),
    showForm() {
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
