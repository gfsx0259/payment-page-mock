import axios from "axios";

export const stubStore = {
    state: () => ({
        stubForm: {
            routeId: null,
            title: '',
            description: '',
        },
        stubs: [],
        isLoading: false,
    }),
    mutations: {
        setFormTitle(state, title) {
            state.stubForm.title = title;
        },
        setFormDescription(state, description) {
            state.stubForm.description = description;
        },
        setFormRouteId(state, routeId) {
            state.stubForm.routeId = routeId;
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
    },
    actions: {
        async fetch({state, commit}) {
            commit('setIsLoading', true);
            const response = await axios.get('http://localhost:8082/api/stub/' + state.stubForm.routeId);

            commit('setStubs', response.data.data);
            commit('setIsLoading', false);
        },
        async create({state, dispatch}) {
            const response = await axios.post(
                'http://localhost:8082/api/stub',
                state.stubForm
            );
            if (response.status === 200) {
                dispatch('fetch')
            }
        },
        async saveDefault({state, dispatch}) {
            const defaultStub = state.stubs.find(stub => stub.default);

            const response = await axios.post(
                'http://localhost:8082/api/stub/setDefault',
                {
                    routeId: state.stubForm.routeId,
                    stubId: defaultStub.id,
                 }
            );
            if (response.status === 200) {
                dispatch('fetch')
            }
        }
    },
    namespaced: true,
}
