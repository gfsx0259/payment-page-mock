<template>
  <CNavbar color="dark" color-scheme="dark">
    <CContainer>
      <CNavbarNav class="d-flex flex-md-row flex-grow-1">
        <CCol xs="8" class="d-flex">
          <CNavItem v-for="item in getItems()" :key="item">
            <CNavLink
              @click="go(item)"
              :disabled="item.routeName === currentRouteName"
            >
              {{ item.title }}
            </CNavLink>
          </CNavItem>
        </CCol>
        <CCol xs="4" v-if="showSearchRouteInput">
          <CForm class="d-flex">
            <CFormInput
              type="search"
              v-bind:value="searchQuery"
              @input="changeSearchQuery"
              class="me-2"
              placeholder="Search"
            />
          </CForm>
        </CCol>
      </CNavbarNav>
    </CContainer>
  </CNavbar>
</template>

<script>
import { mapState, mapMutations } from "vuex";
import {
  MODULE_CALLBACK,
  MODULE_RESOURCE,
  MODULE_ROUTE,
  MODULE_STUB,
} from "@/constants";

export default {
  data() {
    return {
      currentRouteName: null,
      showSearchRouteInput: false,
      items: [
        { level: 1, routeName: MODULE_RESOURCE, title: "resources" },
        { level: 1, routeName: MODULE_ROUTE, title: "routes" },
        { level: 2, routeName: MODULE_STUB, title: "stubs" },
        { level: 3, routeName: MODULE_CALLBACK, title: "callbacks" },
      ],
    };
  },
  computed: {
    ...mapState({
      searchQuery: (state) => state.route.searchQuery,
    }),
  },
  methods: {
    ...mapMutations({
      setSearchQuery: "route/setSearchQuery",
    }),
    changeSearchQuery($event) {
      this.setSearchQuery($event.target.value);
    },
    go(targetItem) {
      this.$router.push({
        name: targetItem.routeName,
        params: this.$route.params,
      });
    },
    getItems() {
      this.currentRouteName = this.$route.name || MODULE_ROUTE;
      this.showSearchRouteInput = this.currentRouteName === MODULE_ROUTE;

      const currentItem = this.items.find(
        (item) => item.routeName === this.currentRouteName
      );

      return this.items.filter((item) => item.level <= currentItem.level);
    },
  },
};
</script>

<style scoped>
.nav-item {
  padding: 0 1rem;
  text-decoration: none;
}
.nav-item a {
  cursor: pointer;
  text-decoration: none;
  text-transform: capitalize;
}
.nav-item:last-child a {
  font-weight: 700;
}
.navbar-nav {
  --cui-navbar-color: rgba(255, 255, 255, 0.8);
}
</style>
