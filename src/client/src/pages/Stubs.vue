<template>
    <CRow>
      <CSpinner class="m-sm-auto" color="dark" v-if="isLoading"/>
    </CRow>
    <Modal
        :title="title"
        :saveCallback="save"
        v-model:visible="visible"
    >
        <StubForm :route-id="this.$route.params.id"/>
    </Modal>
    <CRow v-if="!isLoading">
      <div class="d-flex justify-content-start mb-4">
        <CButton color="light" @click="createFormShow">Add stub</CButton>
      </div>

      <StubItems
          :stubs="stubs"
          @setDefault="changeDefault"
          @remove="remove($event)"
          @edit="editFormShow($event)"
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
          title: '',
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
            loadFormData: 'stub/loadFormByStub',
            cleanFormData: 'stub/cleanForm',
        }),
        ...mapActions({
            fetch: 'stub/fetch',
            save: 'stub/save',
            saveDefault: 'stub/saveDefault',
            remove: 'stub/remove',
        }),
        showForm() {
            this.visible = true;
        },
        changeDefault(id) {
            this.setDefault(id);
            this.saveDefault();
        },
        editFormShow(id) {
            this.title = 'Edit stub';

            this.loadFormData(id);
            this.showForm();
        },
        createFormShow() {
            this.title = 'Create stub';

            this.cleanFormData();
            this.showForm();
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
