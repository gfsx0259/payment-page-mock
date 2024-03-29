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
    <div class="mb-3">
      <CFormLabel for="telegramAlias">Creator`s alias in telegram</CFormLabel>
      <CFormInput
        :model-value="telegramAlias"
        @update:model-value="setTelegramAlias"
        feedbackInvalid="Required. Only latin letters, digits are allowed. Must have @ at the beginning"
        :invalid="invalidFormFields.includes('creator_telegram_alias')"
      />
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
      setTitle: "stub/setFormTitle",
      setDescription: "stub/setFormDescription",
      setTelegramAlias: "stub/setFormCreatorTelegramAlias",
      setCondition: "stub/setCondition",
      addCondition: "stub/addCondition",
    }),
    updateCondition(value, index, type) {
      this.setCondition({ index, value, type });
    },
    create() {
      this.$emit("create", this.stub);
    },
  },
  computed: {
    ...mapState({
      title: (state) => state.stub.form.title,
      description: (state) => state.stub.form.description,
      telegramAlias: (state) => state.stub.form.creator_telegram_alias,
      conditions: (state) => state.stub.form.conditions,
      invalidFormFields: (state) => state.stub.invalidFormFields,
    }),
  },
};
</script>

<style scoped>
.add-control {
  cursor: pointer;
  background-color: var(--cui-body-color);
  padding: 5px;
  color: #fff;
  border-radius: 20px;
}
</style>
