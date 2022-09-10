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
      path: "alphanumeric _",
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
    }
  }
};
