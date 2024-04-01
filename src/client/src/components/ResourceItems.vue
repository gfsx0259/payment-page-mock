<template>
  <CTable bordered striped>
    <CTableHead>
      <CTableHeaderCell class="text-center"> Default </CTableHeaderCell>
      <CTableHeaderCell class="text-center"> Alias </CTableHeaderCell>
      <CTableHeaderCell> Content Type </CTableHeaderCell>
      <CTableHeaderCell> Path </CTableHeaderCell>
      <CTableHeaderCell> Description </CTableHeaderCell>
      <CTableHeaderCell> Conditions </CTableHeaderCell>
      <CTableHeaderCell />
      <CTableHeaderCell />
    </CTableHead>
    <CTableBody>
      <CTableRow v-for="resource in this.resources" :key="resource">
        <CTableDataCell
          class="text-center"
          :class="{ active: resource.default }"
        >
          <CIcon
            icon="cilFlagAlt"
            size="xxl"
            @click="setDefault(resource.id)"
          />
        </CTableDataCell>
        <CTableDataCell class="text-center">{{
          resource.alias
        }}</CTableDataCell>
        <CTableDataCell>{{ resource.content_type }}</CTableDataCell>
        <CTableDataCell>{{ resource.path }}</CTableDataCell>
        <CTableDataCell>{{ resource.description }}</CTableDataCell>
        <CTableDataCell>
          <div class="d-flex flex-wrap conditions-container">
            <CBadge
              v-for="(value, name, index) in resource.conditions"
              :key="index"
              color="dark"
              class="d-inline-block m-1"
            >
              {{ name }} = {{ value }}
            </CBadge>
          </div>
        </CTableDataCell>
        <CTableDataCell class="text-center">
          <CIcon
            icon="cilPencil"
            size="xl"
            class="cursor-pointer m-1"
            @click="edit(resource.id)"
          />
          <CIcon
            icon="cilTrash"
            size="xl"
            class="cursor-pointer m-1"
            @click="remove(resource.id)"
          />
        </CTableDataCell>
      </CTableRow>
    </CTableBody>
  </CTable>
</template>

<script>
export default {
  props: {
    resources: {
      type: Array,
      required: true,
    },
  },
  methods: {
    setDefault(id) {
      this.$emit("setDefault", id);
    },
    remove(id) {
      if (confirm("Are you sure?")) {
        this.$emit("remove", id);
      }
    },
    edit(id) {
      this.$emit("edit", id);
    },
  },
};
</script>

<style scoped>
.active .icon {
  color: darkred;
}
.cursor-pointer {
  cursor: pointer;
}
</style>
