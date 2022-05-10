import { createStore } from 'vuex';
import { stubStore } from "@/store/stubStore";
import { routeStore } from "@/store/routeStore";
import { callbackStore } from "@/store/callbackStore";

export default createStore({
    modules: {
      stub: stubStore,
      route: routeStore,
      callback: callbackStore,
    },
});
