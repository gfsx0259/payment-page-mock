import axios from "axios";

export const routeStore = {
    state: () => ({
        routes: [],
        isLoading: false,
    }),
    mutations: {
        setRoutes(state, routes) {
            state.routes = routes;
        },
        setIsLoading(state, isLoading) {
            state.isLoading = isLoading;
        },
    },
    actions: {
        async fetchRoutes({commit}) {
            commit('setIsLoading', true);
            const response = await axios.get('http://localhost:8082/api/route');

            commit('setRoutes', response.data.data);
            commit('setIsLoading', false);
        },
    },
    namespaced: true,
}
