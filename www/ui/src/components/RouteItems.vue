<template>
    <CRow :lg="{ cols: 4}">
        <CCol xs v-for="mock in mocks">
            <CCard style="width: 19rem">
                <CCardImage v-if="mock.logo" orientation="top" :src="'http://localhost:8082/uploads/route/' + mock.logo" />
                <CCardBody>
                    <CCardTitle>{{ mock.route }}</CCardTitle>
                    <router-link :to="'/route/' + mock.id">
                        <CButton color="dark">Edit</CButton>
                    </router-link>
                </CCardBody>
            </CCard>
        </CCol>
    </CRow>
</template>

<script>
export default {
  name: "RouteItems",
  props: {
      mocks: {
        type: Array,
        required: true
    }
  },
  methods: {
      onSelect (id) {
          this.$emit('select', id)
      }
  },
}
</script>

<style scoped>
.card img {
    max-height: 130px;
}
</style>
