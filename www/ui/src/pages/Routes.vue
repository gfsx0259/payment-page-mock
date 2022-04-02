<template>
    <RouteItems :mocks="routes"/>
    <CSpinner color="warning" v-if="isLoading"/>
</template>

<script>
import RouteItems from '@/components/RouteItems';
import {
    mapActions,
    mapState,
} from "vuex";

export default {
    components: {
        RouteItems,
    },
    methods: {
        ...mapActions({
            fetch: 'route/fetchRoutes',
        }),
    },
    mounted() {
        this.fetch();
    },
    computed: {
        ...mapState({
            routes: state => state.route.routes,
            isLoading: state => state.route.isLoading,
        }),
    }
}
</script>
