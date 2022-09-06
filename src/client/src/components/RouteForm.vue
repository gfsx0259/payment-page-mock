<template>
  <CForm>
    <div class="mb-3">
      <CFormLabel for="route">Path</CFormLabel>
      <CFormInput
        :model-value="route"
        @update:model-value="setRoute"
        placeholder="card/sale"
      />
    </div>
    <div class="mb-3">
      <CFormLabel for="type">Type</CFormLabel>
      <CFormSelect
        :model-value="type"
        @update:model-value="setType"
        :options="types"
      />
    </div>
    <div class="mb-3">
      <CFormLabel for="title">Description</CFormLabel>
      <CFormTextarea :model-value="title" @update:model-value="setTitle" />
    </div>
    <div class="mb-3">
      <FileReader @load="setLogo" />
    </div>
  </CForm>
</template>

<script>
import { mapState, mapMutations } from "vuex";
import FileReader from "@/components/common/FileReader";
import { ROUTE_TYPE_MAP } from "@/constants";

export default {
  name: "RouteForm",
  components: {
    FileReader,
  },
  data() {
    return {
      types: ["Select type"].concat(ROUTE_TYPE_MAP),
    };
  },
  methods: {
    ...mapMutations({
      setTitle: "route/setFormTitle",
      setRoute: "route/setFormRoute",
      setLogo: "route/setFormLogo",
      setType: "route/setFormType",
    }),
    create() {
      this.$emit("create", this.route);
    },
  },
  computed: {
    ...mapState({
      title: (state) => state.route.routeForm.title,
      route: (state) => state.route.routeForm.route,
      logo: (state) => state.route.routeForm.logo,
      type: (state) => state.route.routeForm.type,
    }),
  },
};
</script>
