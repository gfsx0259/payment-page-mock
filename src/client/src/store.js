import { createStore } from 'vuex';
import { stubStore } from "@/store/stubStore";
import { routeStore } from "@/store/routeStore";
import { callbackStore } from "@/store/callbackStore";

export default createStore({
    state: {
      message: null,
    },
    mutations: {
      setMessage(state, message) {
          state.message = message;
      },
    },
    modules: {
      stub: stubStore,
      route: routeStore,
      callback: callbackStore,
    },
});
