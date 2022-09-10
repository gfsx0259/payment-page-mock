<template>
  <CRow :lg="{ cols: 4 }" :md="{ cols: 4 }">
    <CCol xs v-for="route in routes" :key="route">
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
          <CCardTitle class="mb-3">{{ route.path }}</CCardTitle>
          <router-link :to="'/route/' + route.id">
            <CButton color="dark">Stubs</CButton>
          </router-link>
        </CCardBody>
        <RouteType :type="route.type" />
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import { API_URL } from "@/constants";
import RouteType from "@/components/RouteType";

export default {
  components: { RouteType },
  props: {
    routes: {
      type: Array,
      required: true,
    },
  },
  methods: {
    getImagePath(fileName) {
      return API_URL + "/uploads/route/" + fileName;
    },
    remove(id) {
      if (confirm("Are you sure?")) {
        this.$emit("remove", id);
      }
    },
  },
};
</script>

<style scoped>
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
