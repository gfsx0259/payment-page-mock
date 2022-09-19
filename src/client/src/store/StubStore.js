import HttpClient from "@/network/client";
import BaseStore from "@/store/BaseStore";
import { MODULE_STUB } from "@/constants";

export default class StubStore extends BaseStore {
  endpoint() {
    return MODULE_STUB;
  }

  state() {
    return {
      ...super.state(),
      form: {
        title: "",
        description: "",
      },
    };
  }

  rules() {
    return {
      title: "alphanumeric _space_",
    };
  }

  mutations() {
    return {
      ...super.mutations(),
      setFormTitle(state, title) {
        state.form.title = title;
      },
      setFormDescription(state, description) {
        state.form.description = description;
      },
      loadFormByStub(state, stubId) {
        const stub = state.entities.find((stub) => stub.id === stubId);

        state.form.id = stub.id;
        state.form.title = stub.title;
        state.form.description = stub.description;
      },
      cleanForm(state) {
        state.form.id = null;
        state.form.title = "";
        state.form.description = "";
      },
      setDefault(state, id) {
        state.entities.map((stub) => {
          stub.default = stub.id === id;
          return stub;
        });
      },
    };
  }

  actions() {
    return {
      ...super.actions(),
      saveDefault: async ({ state, dispatch, commit }) => {
        const defaultStub = state.entities.find((stub) => stub.default);

        try {
          await HttpClient.post(`${this.endpoint()}/setDefault`, {
            routeId: state.relationId,
            stubId: defaultStub.id,
          });

          dispatch("fetch");
        } catch (error) {
          commit("setMessage", { text: error }, { root: true });
        }
      },
    };
  }
}
