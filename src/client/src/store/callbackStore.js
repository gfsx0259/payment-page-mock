import HttpClient from "@/network/client";

export const callbackStore = {
    state: () => ({
        form: {
            stubId: null,
            id: null,
            body: {},
        },
        callbacks: [],
        isLoading: false,
    }),
    mutations: {
        setFormStubId(state, stubId) {
            state.form.stubId = stubId;
        },
        setFormId(state, id) {
            state.form.id = id;
        },
        setFormBody(state, body) {
            state.form.body = body;
        },
        setCallbacks(state, callbacks) {
            state.callbacks = callbacks;
        },
        setIsLoading(state, isLoading) {
            state.isLoading = isLoading;
        },
    },
    actions: {
        async fetch({state, commit}) {
            commit('setIsLoading', true);
            const response = await HttpClient.get('callback/' + state.form.stubId);

            commit('setCallbacks', response.data.data);
            commit('setIsLoading', false);
        },
        async update({state}) {
            const callbackData = {
                id: state.form.id,
                stubId: state.form.stubId,
                callback: state.form.body || {}
            };

            await HttpClient.post('stub/callback', callbackData);
        },
    },
    namespaced: true,
}
