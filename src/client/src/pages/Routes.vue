<template>
    <Modal
        title="Create route"
        v-model:visible="visible"
        :saveCallback="create"
    >
        <RouteForm/>
    </Modal>
    <div class="d-flex justify-content-start mb-4">
        <CButton color="light" @click="showForm">Add route</CButton>
    </div>
    <RouteItems :routes="searchedRoutes" v-if="!isLoading"/>
    <RoutePlaceholder v-if="isLoading"/>
</template>

<script>
import Modal from "@/components/common/Modal";
import RouteItems from '@/components/RouteItems';
import RoutePlaceholder from "@/components/RoutePlaceholder";
import RouteForm from "@/components/RouteForm";
import {
    mapActions,
    mapState,
} from "vuex";

export default {
    components: {
        RouteForm,
        RoutePlaceholder,
        RouteItems,
        Modal,
    },
    data () {
        return {
            visible: false,
        }
    },
    methods: {
        ...mapActions({
            fetch: 'route/fetchRoutes',
            create: 'route/createRoute',
        }),
        showForm() {
            this.visible = true;
        },
    },
    mounted() {
        this.fetch();
    },
    computed: {
        ...mapState({
            routes: state => state.route.routes,
            isLoading: state => state.route.isLoading,
            searchQuery: state => state.route.searchQuery,
        }),
        searchedRoutes() {
          return this.routes.filter(route => route.route.includes(this.searchQuery));
        }
    }
}
</script>

<style>
.card {
    align-items: center;
}
.card img {
    height: 110px;
    max-width: 12rem;
}
.card-body {
    width:100%;
    padding: 1rem 2rem;
}
</style>
