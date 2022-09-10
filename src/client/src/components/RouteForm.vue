<template>
  <CForm>
    <div class="mb-3">
      <CFormLabel for="route">Path</CFormLabel>
      <CFormInput
        feedbackInvalid="Required. No spaces must be here. Only latin letters, digits, slashes, underscores, hyphens are allowed."
        :invalid="invalidFormFields.includes('path')"
        :model-value="route"
        @update:model-value="setPath"
        placeholder="unique-path/action"
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
      <CFormTextarea
          :model-value="title"
          @update:model-value="setDescription"
      />
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
      setPath: "route/setPath",
      setType: "route/setType",
      setDescription: "route/setDescription",
      setLogo: "route/setLogo",
    }),
    create() {
      this.$emit("create", this.route);
    },
  },
  computed: {
    ...mapState({
      path: (state) => state.route.form.path,
      type: (state) => state.route.form.type,
      description: (state) => state.route.form.description,
      logo: (state) => state.route.form.logo,
      invalidFormFields: (state) => state.route.invalidFormFields,
    }),
  },
};
</script>
