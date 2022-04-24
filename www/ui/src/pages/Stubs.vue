<template>
    <Modal
        title="Create stub"
        v-model:visible="visible"
        :saveCallback="create"
    >
        <StubForm :route-id="this.$route.params.id"/>
    </Modal>
    <div class="d-flex justify-content-start mb-4">
        <CButton color="light" @click="showForm">Add stub</CButton>
    </div>

    <StubItems :stubs="stubs" @setDefault="changeDefault"/>
    <CSpinner color="warning" v-if="isLoading"/>
</template>

<script>
import Modal from "@/components/common/Modal";
import StubItems from "@/components/StubItems";
import StubForm from "@/components/StubForm";
import {
    mapState,
    mapActions,
    mapMutations,
} from 'vuex';

export default {
    components: {
        StubForm,
        Modal,
        StubItems,
    },
    data () {
      return {
          visible: false,
      }
    },
    mounted() {
        this.setRoute(parseInt(this.$route.params.id));
        this.fetch();
    },
    methods: {
        ...mapMutations({
            setRoute: 'stub/setFormRouteId',
            setDefault: 'stub/setDefault',
        }),
        ...mapActions({
            fetch: 'stub/fetch',
            create: 'stub/create',
            saveDefault: 'stub/saveDefault',
        }),
        showForm() {
            this.visible = true;
        },
        changeDefault(id) {
            this.setDefault(id);
            this.saveDefault();
        },
    },
    computed: {
        ...mapState({
            stubs: state => state.stub.stubs,
            isLoading: state => state.stub.isLoading,
        }),
    }
}
</script>
