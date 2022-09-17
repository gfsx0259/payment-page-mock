import BaseStore from "@/store/BaseStore";
import { MODULE_ROUTE } from "@/constants";

export default class RouteStore extends BaseStore {
  endpoint() {
    return MODULE_ROUTE;
  }

  state() {
    return {
      ...super.state(),
      form: {
        path: "",
        type: null,
        description: "",
        logo: "",
      },
      searchQuery: "",
    }
  }

  rules() {
    return {
      path: "alphanumeric _/-",
      type: "numeric",
    };
  }


  mutations() {
    return {
      ...super.mutations(),
      setPath(state, path) {
        state.form.path = path;
      },
      setType(state, type) {
        state.form.type = type;
      },
      setDescription(state, description) {
        state.form.description = description;
      },
      setLogo(state, logo) {
        state.form.logo = logo;
      },
      setSearchQuery(state, searchQuery) {
        state.searchQuery = searchQuery;
      },
      loadForm(state, id) {
        const route = state.entities.find((route) => route.id === id);

        state.form.id = id;
        state.form.path = route.path;
        state.form.type = route.type;
        state.form.description = route.description;
        state.form.logo = route.logo;
      },
      clean(state) {
        state.form.path = "";
        state.form.type = null;
        state.form.description = "";
        state.form.logo = "";
      },
    }
  }
};
