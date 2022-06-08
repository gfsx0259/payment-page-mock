import HttpClient from "@/network/client";

export const stubStore = {
    state: () => ({
        stubForm: {
            id: null,
            routeId: null,
            title: '',
            description: '',
        },
        stubs: [],
        isLoading: false,
    }),
    mutations: {
        setFormId(state, id) {
            state.stubForm.id = id;
        },
        setFormTitle(state, title) {
            state.stubForm.title = title;
        },
        setFormDescription(state, description) {
            state.stubForm.description = description;
        },
        setFormRouteId(state, routeId) {
            state.stubForm.routeId = routeId;
        },
        loadFormByStub(state, stubId) {
            const stub = state.stubs.find(stub => stub.id === stubId);

            state.stubForm.id = stub.id;
            state.stubForm.title = stub.title;
            state.stubForm.description = stub.description;
        },
        cleanForm(state) {
            state.stubForm.id = null;
            state.stubForm.title = '';
            state.stubForm.description = '';
        },
        setStubs(state, stubs) {
            state.stubs = stubs;
        },
        setDefault(state, id) {
            state.stubs.map((stub) => {
                stub.default = stub.id === id;
                return stub;
            })
        },
        setIsLoading(state, isLoading) {
            state.isLoading = isLoading;
        },
        remove(state, id) {
            const stub = state.stubs.find(stub => stub.id === id);
            const index = state.stubs.indexOf(stub);

            state.stubs.splice(index, 1);
        },
    },
    actions: {
        async fetch({state, commit}) {
            commit('setIsLoading', true);
            const response = await HttpClient.get('stub/' + state.stubForm.routeId);

            commit('setStubs', response.data.data);
            commit('setIsLoading', false);
        },
        async save({state, dispatch}) {
            if (state.stubForm.id === null) {
                dispatch('create');
            } else {
                dispatch('update');
            }
        },
        async create({state, dispatch}) {
            const response = await HttpClient.post(
                'stub',
                state.stubForm
            );
            if (response.status === 200) {
                dispatch('fetch')
            }
        },
        async update({state, dispatch}) {
            const response = await HttpClient.put(
                'stub',
                state.stubForm
            );
            if (response.status === 200) {
                dispatch('fetch')
            }
        },
        async saveDefault({state, dispatch}) {
            const defaultStub = state.stubs.find(stub => stub.default);

            const response = await HttpClient.post(
                'stub/setDefault',
                {
                    routeId: state.stubForm.routeId,
                    stubId: defaultStub.id,
                 }
            );
            if (response.status === 200) {
                dispatch('fetch')
            }
        },
        async remove({state, commit, dispatch}, id) {
            commit('remove', id);

            HttpClient
                .delete(`stub/${id}`)
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
