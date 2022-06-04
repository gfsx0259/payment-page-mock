<template>
    <CRow :lg="{ cols: 4 }" :md="{ cols: 4 }">
        <CCol xs v-for="route in routes">
            <CCard style="width: 18rem" class="mb-4">
                <CIcon
                  icon="cilX"
                  size="xl"
                  class="delete-btn m-1"
                  @click="remove(route.id)"
                />
                <CCardImage
                    v-if="route.logo"
                    orientation="top"
                    class="mt-2"
                    :src="this.getImagePath(route.logo)"
                />
                <CCardBody>
                    <CCardTitle class="mb-3">{{ route.route }}</CCardTitle>
                    <router-link :to="'/route/' + route.id">
                        <CButton color="dark">Stubs</CButton>
                    </router-link>
                </CCardBody>
                <CBadge color="danger">card</CBadge>
            </CCard>
        </CCol>
    </CRow>
</template>

<script>
import { API_URL } from "@/constants";

export default {
  name: "RouteItems",
    props: {
      routes: {
        type: Array,
        required: true,
      },
  },
  methods: {
    getImagePath(fileName) {
      return API_URL + '/uploads/route/' + fileName;
    },
    remove(id) {
      if (confirm('Are you sure?')) {
        this.$emit('remove', id);
      }
    }
  }
}
</script>

<style scoped>
.badge {
    position: absolute;
    top: 0;
    left: 0;
    border-radius: 5px 0 5px 0;
}
.card:hover .delete-btn {
  display: block;
}
.delete-btn {
  position: absolute;
  display: none;
  right: 0;
  cursor: pointer;
}
</style>
