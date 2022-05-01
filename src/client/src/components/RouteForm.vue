<template>
    <CForm>
        <div class="mb-3">
            <CFormLabel for="route">Path</CFormLabel>
            <CFormInput
                :model-value="route"
                @update:model-value="setRoute"
                placeholder="card/sale"
                id="route"
            />
        </div>
        <div class="mb-3">
            <CFormLabel for="title">Description</CFormLabel>
            <CFormTextarea
                :model-value="title"
                @update:model-value="setTitle"
                type="text"
                id="title"
            />
        </div>
        <div class="mb-3">
            <FileReader @load="setLogo"/>
        </div>
    </CForm>
</template>

<script>
import {
    mapState,
    mapMutations,
} from 'vuex';
import FileReader from "@/components/common/FileReader";

export default {
    name: "RouteForm",
    components: {
        FileReader,
    },
    methods: {
        ...mapMutations({
            setTitle: 'route/setFormTitle',
            setRoute: 'route/setFormRoute',
            setLogo: 'route/setFormLogo',
        }),
        create() {
            this.$emit('create', this.route);
        },
    },
    computed: {
        ...mapState({
            title: state => state.route.routeForm.title,
            route: state => state.route.routeForm.route,
            logo: state => state.route.routeForm.logo,
        }),
    }
}
</script>
