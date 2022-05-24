<template>
    <CRow :lg="{ cols: 4 }" :md="{ cols: 4 }">
        <CCol xs v-for="mock in mocks">
            <CCard style="width: 19rem" class="mb-4">
                <CCardImage
                    v-if="mock.logo"
                    orientation="top"
                    :src="this.getImagePath(mock.logo)"
                />
                <CCardBody>
                    <CCardTitle>{{ mock.route }}</CCardTitle>
                    <router-link :to="'/route/' + mock.id">
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
      mocks: {
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
    max-height: 140px;
    margin-top: 5px;
    background-repeat: no-repeat;
    background-position: center;
}
</style>
