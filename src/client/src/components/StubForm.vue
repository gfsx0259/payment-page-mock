<template>
  <CForm>
    <div class="mb-3">
      <CFormLabel for="title">Title</CFormLabel>
      <CFormInput
        :model-value="title"
        @update:model-value="setTitle"
        feedbackInvalid="Required. Only latin letters, digits are allowed."
        :invalid="invalidFormFields.includes('title')"
      />
    </div>
    <div class="mb-3">
      <CFormLabel for="description">Description</CFormLabel>
      <CFormTextarea
        :model-value="description"
        @update:model-value="setDescription"
      />
    </div>
  </CForm>
</template>

<script>
import { mapState, mapMutations } from "vuex";

export default {
  methods: {
    ...mapMutations({
      setTitle: "stub/setFormTitle",
      setDescription: "stub/setFormDescription",
    }),
    create() {
      this.$emit("create", this.stub);
    },
  },
  computed: {
    ...mapState({
      title: (state) => state.stub.form.title,
      description: (state) => state.stub.form.description,
      invalidFormFields: (state) => state.stub.invalidFormFields,
    }),
  },
};
</script>
