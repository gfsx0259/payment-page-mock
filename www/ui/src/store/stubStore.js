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
        setIsLoading(state, isLoading) {
            state.isLoading = isLoading;
        },
    },
    actions: {
        async fetchStubs({state, commit}) {
            commit('setIsLoading', true);
            const response = await axios.get('http://localhost:8082/api/stub/' + state.stubForm.routeId);

            commit('setStubs', response.data.data);
            commit('setIsLoading', false);
        },
        async createStub({state, dispatch}) {
            const response = await axios.post(
                'http://localhost:8082/api/stub',
                state.stubForm
            );
            if (response.status === 200) {
                dispatch('fetchStubs')
            }
        }
    },
    namespaced: true,
}
