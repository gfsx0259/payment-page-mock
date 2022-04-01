import { createStore } from 'vuex';
import { stubStore } from "@/store/stubStore";

export default createStore({
    modules: {
      stub: stubStore,
    },
});
