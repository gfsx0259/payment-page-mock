<template>
  <CCallout color="dark" v-if="!this.stubs.length">
    This route has not scenarios yet. Please create your first scenario and
    adjust it
  </CCallout>
  <CTable bordered striped v-if="this.stubs.length">
    <CTableHead>
      <CTableHeaderCell class="text-center"> Default </CTableHeaderCell>
      <CTableHeaderCell> Title </CTableHeaderCell>
      <CTableHeaderCell> Description </CTableHeaderCell>
      <CTableHeaderCell> Creator`s telegram alias </CTableHeaderCell>
      <CTableHeaderCell> Conditions </CTableHeaderCell>
      <CTableHeaderCell />
      <CTableHeaderCell />
    </CTableHead>
    <CTableBody>
      <CTableRow v-for="stub in this.stubs" :key="stub">
        <CTableDataCell class="text-center" :class="{ active: stub.default }">
          <CIcon icon="cilFlagAlt" size="xxl" @click="setDefault(stub.id)" />
        </CTableDataCell>
        <CTableDataCell>{{ stub.title }}</CTableDataCell>
        <CTableDataCell>{{ stub.description }}</CTableDataCell>
        <CTableDataCell>{{ stub.creator_telegram_alias }}</CTableDataCell>
        <CTableDataCell>
          <div class="d-flex flex-wrap conditions-container">
            <CBadge
              v-for="(value, name, index) in stub.conditions"
              :key="index"
              color="dark"
              class="d-inline-block m-1"
            >
              {{ name }} = {{ value }}
            </CBadge>
          </div>
        </CTableDataCell>
        <CTableDataCell class="text-center">
          <router-link :to="'/route/' + routeId + '/stub/' + stub.id">
            <CButton color="dark">Callbacks</CButton>
          </router-link>
        </CTableDataCell>
        <CTableDataCell class="text-center">
          <CIcon
            icon="cilPencil"
            size="xl"
            class="cursor-pointer m-1"
            @click="edit(stub.id)"
          />
          <CIcon
            icon="cilTrash"
            size="xl"
            class="cursor-pointer m-1"
            @click="remove(stub.id)"
          />
        </CTableDataCell>
      </CTableRow>
    </CTableBody>
  </CTable>
</template>

<script>
export default {
  props: {
    stubs: {
      type: Array,
      required: true,
    },
    routeId: {
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
.conditions-container {
  width: 200px;
}
.active .icon {
  color: darkred;
}
.cursor-pointer {
  cursor: pointer;
}
</style>
