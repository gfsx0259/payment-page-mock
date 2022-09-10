import HttpClient from "@/network/client";

export const routeStore = {
  state: () => ({
    routeForm: {
      route: "",
      title: "",
      logo: "",
      type: null,
    },
    routes: [],
    isLoading: false,
    searchQuery: "",
  }),
  mutations: {
    setFormRoute(state, route) {
      state.routeForm.route = route;
    },
    setFormTitle(state, title) {
      state.routeForm.title = title;
    },
    setFormLogo(state, logo) {
      state.routeForm.logo = logo;
    },
    setFormType(state, type) {
      state.routeForm.type = type;
    },
    setRoutes(state, routes) {
      state.routes = routes;
    },
    setIsLoading(state, isLoading) {
      state.isLoading = isLoading;
    },
    setSearchQuery(state, searchQuery) {
      state.searchQuery = searchQuery;
    },
    remove(state, id) {
      const route = state.routes.find((route) => route.id === id);
      const index = state.routes.indexOf(route);

      state.routes.splice(index, 1);
    },
  },
  actions: {
    async fetchRoutes({ commit }) {
      commit("setIsLoading", true);
      const response = await HttpClient.get("route");

      commit("setRoutes", response.data.data);
      commit("setIsLoading", false);
    },
    async createRoute({ state, dispatch }) {
      const response = await HttpClient.post("route", state.routeForm);
      if (response.status === 200) {
        dispatch("fetchRoutes");
      }
    },
    async remove({ dispatch, commit }, id) {
      commit("remove", id);

      HttpClient.delete(`route/${id}`).catch(() => {
        dispatch("fetchRoutes");
      });
    },
  },
  namespaced: true,
};
