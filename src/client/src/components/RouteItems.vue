<template>
    <CRow :lg="{ cols: 4 }" :md="{ cols: 4 }">
        <CCol xs v-for="route in routes">
            <CCard style="width: 18rem" class="mb-4">
                <CCardImage
                    v-if="route.logo"
                    orientation="top"
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
.card-img-top {
    max-height: 110px;
    margin-top: 5px;
    background-repeat: no-repeat;
    background-position: center;
}
</style>
