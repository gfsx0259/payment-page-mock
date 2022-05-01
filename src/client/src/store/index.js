import { createStore } from 'vuex';
import { stubStore } from "@/store/stubStore";
import { routeStore } from "@/store/routeStore";

export default createStore({
    modules: {
      stub: stubStore,
      route: routeStore,
    },
});
