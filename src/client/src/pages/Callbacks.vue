<template>
  <CRow>
    <CSpinner class="m-sm-auto" color="dark" v-if="isLoading"/>
  </CRow>
   <CallbackItems
     :callbacks="callbacks"
     @add="add"
     @update="update"
     @remove="remove"
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
    await this.fetch();
  },
  methods: {
    ...mapMutations({
      add: 'callback/add',
      setStub: 'callback/setFormStubId',
    }),
    ...mapActions({
      fetch: 'callback/fetch',
      update: 'callback/update',
      remove: 'callback/remove',
    }),
  },
  computed: {
    ...mapState({
      callbacks: state => state.callback.callbacks,
      isLoading: state => state.callback.isLoading,
    }),
  }
}
</script>
