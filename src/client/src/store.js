import { createStore } from "vuex";
import StubStore from "@/store/StubStore";
import RouteStore from "@/store/RouteStore";
import ResourceStore from "@/store/ResourceStore";
import { callbackStore } from "@/store/callbackStore";
import {
  MODULE_ROUTE,
  MODULE_STUB,
  MODULE_CALLBACK,
  MODULE_RESOURCE,
} from "@/constants";

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
    [MODULE_STUB]: new StubStore().getModule(),
    [MODULE_ROUTE]: new RouteStore().getModule(),
    [MODULE_CALLBACK]: callbackStore,
    [MODULE_RESOURCE]: new ResourceStore().getModule(),
  },
});
