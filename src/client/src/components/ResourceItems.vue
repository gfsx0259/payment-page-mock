<template>
  <CTable bordered striped>
    <CTableHead>
      <CTableHeaderCell class="text-center"> Alias </CTableHeaderCell>
      <CTableHeaderCell> Content Type </CTableHeaderCell>
      <CTableHeaderCell> Path </CTableHeaderCell>
      <CTableHeaderCell> Description </CTableHeaderCell>
      <CTableHeaderCell />
      <CTableHeaderCell />
    </CTableHead>
    <CTableBody>
      <CTableRow v-for="resource in this.resources" :key="resource">
        <CTableDataCell class="text-center">{{
          resource.alias
        }}</CTableDataCell>
        <CTableDataCell>{{ resource.content_type }}</CTableDataCell>
        <CTableDataCell>{{ resource.path }}</CTableDataCell>
        <CTableDataCell>{{ resource.description }}</CTableDataCell>
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
.cursor-pointer {
  cursor: pointer;
}
</style>
