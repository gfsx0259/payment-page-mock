<template>
  <CForm>
    <div class="mb-3">
      <CFormLabel for="alias">Alias</CFormLabel>
      <CFormInput
        type="text"
        id="alias"
        feedbackInvalid="Required. Only latin capital letters and underscores can be used"
        :invalid="invalidFormFields.includes('alias')"
        :model-value="alias"
        @update:model-value="setAlias"
      />
    </div>
    <div class="mb-3">
      <CFormLabel for="path">Path</CFormLabel>
      <CFormInput
        type="text"
        id="path"
        feedbackInvalid="Required. No spaces must be here. Only latin letters, digits, slashes, underscores, hyphens are allowed. One slash at the beginning is required"
        :invalid="invalidFormFields.includes('path')"
        :model-value="path"
        @update:model-value="setPath"
      />
    </div>
    <div class="mb-3">
      <CFormLabel for="description">Description</CFormLabel>
      <CFormInput
        type="text"
        id="description"
        :invalid="invalidFormFields.includes('description')"
        :model-value="description"
        @update:model-value="setDescription"
      />
    </div>
    <div class="mb-3">
      <CFormLabel for="content-type">Content Type</CFormLabel>
      <CFormSelect
        id="content-type"
        :invalid="invalidFormFields.includes('content_type')"
        :model-value="content_type"
        @update:model-value="setContentType"
      >
        <option value="application/json">application/json</option>
        <option value="application/javascript">application/javascript</option>
      </CFormSelect>
    </div>
    <div class="mb-3">
      <CFormLabel for="content">Content</CFormLabel>
      <CFormTextarea
        id="content"
        :invalid="invalidFormFields.includes('content')"
        :model-value="content"
        @update:model-value="setContent"
      >
      </CFormTextarea>
    </div>
    <div class="mb-3">
      <div class="d-flex justify-content-between flex-row">
        <CFormLabel for="telegramAlias">Conditions</CFormLabel>
        <CIcon
          icon="cilPlaylistAdd"
          size="xl"
          class="add-control"
          @click="addCondition"
        />
      </div>
      <div v-if="!this.conditions.length" class="text-black-50 text-center">
        conditions are not specified
      </div>
      <div v-for="(condition, index) in this.conditions" :key="index">
        <CInputGroup class="mb-3">
          <CFormInput
            placeholder="Field"
            :value="condition[0]"
            @update:model-value="
              (value) => {
                updateCondition(value, index, 0);
              }
            "
          />
          <CInputGroupText>=</CInputGroupText>
          <CFormInput
            placeholder="Value"
            :value="condition[1]"
            @update:model-value="
              (value) => {
                updateCondition(value, index, 1);
              }
            "
          />
        </CInputGroup>
      </div>
    </div>
  </CForm>
</template>

<script>
import { mapState, mapMutations } from "vuex";

export default {
  methods: {
    ...mapMutations({
      setAlias: "resource/setAlias",
      setPath: "resource/setPath",
      setDescription: "resource/setDescription",
      setContentType: "resource/setContentType",
      setContent: "resource/setContent",
      setCondition: "resource/setCondition",
      addCondition: "resource/addCondition",
    }),
    updateCondition(value, index, type) {
      this.setCondition({ index, value, type });
    },
  },
  computed: {
    ...mapState({
      alias: (state) => state.resource.form.alias,
      path: (state) => state.resource.form.path,
      description: (state) => state.resource.form.description,
      content_type: (state) => state.resource.form.content_type,
      content: (state) => state.resource.form.content,
      conditions: (state) => state.resource.form.conditions,
      invalidFormFields: (state) => state.resource.invalidFormFields,
    }),
  },
};
</script>
