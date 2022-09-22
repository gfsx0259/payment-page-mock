import HttpClient from "@/network/client";

export const callbackStore = {
  state: () => ({
    form: {
      stubId: null,
    },
    callbacks: [],
    dynamicTemplateVariables: [],
    isLoading: false,
  }),
  mutations: {
    setFormStubId(state, stubId) {
      state.form.stubId = stubId;
    },
    setCallbacks(state, callbacks) {
      state.callbacks = callbacks;
    },
    setDynamicTemplateVariables(state, templateVariables) {
      state.dynamicTemplateVariables = templateVariables;
    },
    setIsLoading(state, isLoading) {
      state.isLoading = isLoading;
    },
    add(state) {
      state.callbacks.push({ id: null });
    },
    remove(state, id) {
      state.callbacks = state.callbacks.filter(
        (callback) => callback.id !== id
      );
    },
  },
  actions: {
    async fetch({ state, commit }) {
      commit("setIsLoading", true);
      const response = await HttpClient.get("callback/" + state.form.stubId);

      commit("setCallbacks", response.data.data);
      commit("setIsLoading", false);
    },
    async fetchDynamicTemplateVariables({ state, commit }) {
      if (!state.dynamicTemplateVariables.length) {
        const response = await HttpClient.get("resource/template-variables");

        commit("setDynamicTemplateVariables", response.data.data);
      }
    },
    async update({ state, commit, dispatch }, { id, callback }) {
      try {
        await HttpClient.post("stub/callback", {
          id,
          callback: callback || {},
          stubId: state.form.stubId,
        });
        commit("setMessage", { text: "Saved successfully" }, { root: true });

        dispatch("fetch");
      } catch (error) {
        commit("setMessage", { text: error }, { root: true });
      }
    },
    async remove({ commit, dispatch }, id) {
      commit("remove", id);

      if (id === null) {
        commit(
          "setMessage",
          { text: `Remove unsaved callbacks` },
          { root: true }
        );
        return;
      }

      try {
        await HttpClient.delete(`callback/${id}`);
        commit("setMessage", { text: "Delete successfully" }, { root: true });
      } catch (error) {
        commit("setMessage", { text: error }, { root: true });

        dispatch("fetch");
      }
    },
  },
  namespaced: true,
};
