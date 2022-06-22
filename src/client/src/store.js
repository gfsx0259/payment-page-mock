import { createStore } from 'vuex';
import StubStore from "@/store/StubStore";
import { routeStore } from "@/store/routeStore";
import { callbackStore } from "@/store/callbackStore";
import { MODULE_ROUTE, MODULE_STUB, MODULE_CALLBACK } from "@/constants";

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
      [MODULE_STUB]: (new StubStore()).getModule(),
      [MODULE_ROUTE]: routeStore,
      [MODULE_CALLBACK]: callbackStore,
    },
});
