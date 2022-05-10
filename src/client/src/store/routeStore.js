import HttpClient from "@/network/client";

export const routeStore = {
    state: () => ({
        routeForm: {
            route: '',
            title: '',
            logo: '',
        },
        routes: [],
        isLoading: false,
    }),
    mutations: {
        setFormRoute(state, route) {
            state.routeForm.route = route;
        },
        setFormTitle(state, title) {
            state.routeForm.title = title;
        },
        setFormLogo(state, logo) {
            state.routeForm.logo = logo;
        },
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
            const response = await HttpClient.get('route');

            commit('setRoutes', response.data.data);
            commit('setIsLoading', false);
        },
        async createRoute({state, dispatch}) {
            const response = await HttpClient.post(
                'route',
                state.routeForm
            );
            if (response.status === 200) {
                dispatch('fetchRoutes')
            }
        }
    },
    namespaced: true,
}
