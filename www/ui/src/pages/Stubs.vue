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

    <StubItems :stubs="stubs"/>
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
        this.setRoute(this.$route.params.id);
        this.fetch();
    },
    methods: {
        ...mapMutations({
            setRoute: 'stub/setFormRouteId',
        }),
        ...mapActions({
            fetch: 'stub/fetchStubs',
            create: 'stub/createStub',
        }),
        showForm() {
            this.visible = true;
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
