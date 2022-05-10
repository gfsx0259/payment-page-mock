<template>
  <CRow>
    <CSpinner class="m-sm-auto" color="dark" v-if="isLoading"/>
  </CRow>
   <CallbackItems
       :callbacks="callbacks"
       @update="updateCallback"
       v-if="!isLoading"
   />
</template>

<script>
import CallbackItems from "@/components/CallbackItems";
import {
  mapActions,
  mapState,
  mapMutations,
} from "vuex";

export default {
    components: {
        CallbackItems,
    },
    async mounted() {
        this.setStub(this.$route.params.id);
        this.fetch();
    },
    methods: {
        ...mapMutations({
          setStub: 'callback/setFormStubId',
          setBody: 'callback/setFormBody',
          setId: 'callback/setFormId',
        }),
        ...mapActions({
          fetch: 'callback/fetch',
          update: 'callback/update',
        }),
        updateCallback(id, body) {
          this.setId(id);
          this.setBody(body);
          this.update();
        }
    },
    computed: {
      ...mapState({
        callbacks: state => state.callback.callbacks,
        isLoading: state => state.callback.isLoading,
      }),
    }
}
</script>
