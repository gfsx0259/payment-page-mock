<template>
    <CRow>
      <CSpinner class="m-sm-auto" color="dark" v-if="isLoading"/>
    </CRow>
    <Modal
        title="Create stub"
        :saveCallback="create"
        v-model:visible="visible"
    >
        <StubForm :route-id="this.$route.params.id"/>
    </Modal>
    <CRow v-if="!isLoading">
      <div class="d-flex justify-content-start mb-4">
        <CButton color="light" @click="showForm">Add stub</CButton>
      </div>

      <StubItems
          :stubs="stubs"
          @setDefault="changeDefault"
      />
    </CRow>
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
