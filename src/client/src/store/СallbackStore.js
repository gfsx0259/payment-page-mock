import BaseStore from "@/store/BaseStore";
import { MODULE_CALLBACK } from "@/constants";
import HttpClient from "@/network/client";

export default class CallbackStore extends BaseStore {
  endpoint() {
    return MODULE_CALLBACK;
  }

  state() {
    return {
      ...super.state(),
      dynamicTemplateVariables: [],
    };
  }

  mutations() {
    return {
      ...super.mutations(),
      setDynamicTemplateVariables(state, templateVariables) {
        state.dynamicTemplateVariables = templateVariables;
      },
      sort(state, orderedIds) {
        state.entities.sort((callbackCurrent, callbackPrevious) => {
          const indexCurrent = orderedIds.indexOf(callbackCurrent.id);
          const indexPrevious = orderedIds.indexOf(callbackPrevious.id);

          return indexCurrent < indexPrevious ? -1 : 1;
        });
      },
      add(state) {
        state.entities.push({ id: null });
      },
    };
  }

  actions() {
    return {
      ...super.actions(),
      async fetchDynamicTemplateVariables({ state, commit }) {
        if (!state.dynamicTemplateVariables.length) {
          const response = await HttpClient.get("resource/template-variables");

          commit("setDynamicTemplateVariables", response.data.data);
        }
      },
      async changeOrder({ state, commit }, ids) {
        try {
          await HttpClient.patch("callback/" + state.relationId, ids);
          commit("sort", ids);
          commit(
            "setMessage",
            { text: "Order changed successfully" },
            { root: true }
          );
        } catch (error) {
          commit("setMessage", { text: error }, { root: true });
        }
      },
    };
  }
}
