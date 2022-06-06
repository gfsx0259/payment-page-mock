import HttpClient from "@/network/client";

export const callbackStore = {
    state: () => ({
        form: {
            stubId: null,
        },
        callbacks: [],
        isLoading: false,
    }),
    mutations: {
        setFormStubId(state, stubId) {
            state.form.stubId = stubId;
        },
        setCallbacks(state, callbacks) {
            state.callbacks = callbacks;
        },
        setIsLoading(state, isLoading) {
            state.isLoading = isLoading;
        },
        add(state) {
            state.callbacks.push({id: null})
        },
        remove(state, id) {
            const callback = state.callbacks.find(callback => callback.id === id);
            const index = state.callbacks.indexOf(callback);

            state.callbacks.splice(index, 1);
        },
    },
    actions: {
        async fetch({state, commit}) {
            commit('setIsLoading', true);
            const response = await HttpClient.get('callback/' + state.form.stubId);

            commit('setCallbacks', response.data.data);
            commit('setIsLoading', false);
        },
        async update({state, commit, dispatch}, {id, body}) {
            const callbackData = {
                stubId: state.form.stubId,
                id: id,
                callback: body || {}
            };

            await HttpClient.post('stub/callback', callbackData);

            dispatch('fetch');
            commit('setMessage', { text: 'Saved successfully' }, { root: true })
        },
        async remove({state, commit, dispatch}, id) {
            commit('remove', id);

            if (id === null) {
                commit('setMessage', { text: `Remove unsaved callback` }, { root: true })
                return;
            }

            HttpClient
                .delete(`callback/${id}`)
                .catch(
                    ({response}) => {
                        const data = response.data;

                        commit('setMessage', { text: `Request failed: ${data.error.message}` }, { root: true })
                        dispatch('fetch');
                    }
                )
            ;
        }
    },
    namespaced: true,
}
