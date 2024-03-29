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
        creator_telegram_alias: "",
        conditions: [[]],
      },
    };
  }

  rules() {
    return {
      title: "alphanumeric _space_",
      creator_telegram_alias: ["alphanumeric _@", "startsWith @"],
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
      setFormCreatorTelegramAlias(state, telegramAlias) {
        state.form.creator_telegram_alias = telegramAlias;
      },
      loadFormByStub(state, stubId) {
        const stub = state.entities.find((stub) => stub.id === stubId);

        state.form.id = stub.id;
        state.form.title = stub.title;
        state.form.description = stub.description;
        state.form.creator_telegram_alias = stub.creator_telegram_alias;
        state.form.conditions = Object.entries(stub.conditions);
      },
      setCondition(state, condition) {
        state.form.conditions[condition.index][condition.type] =
          condition.value;
      },
      addCondition(state) {
        state.form.conditions.push([]);
      },
      cleanForm(state) {
        state.form.id = null;
        state.form.title = "";
        state.form.description = "";
        state.form.creator_telegram_alias = "";
        state.form.conditions = [];
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
