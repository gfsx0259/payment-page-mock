<template>
    <CNavbar color="dark" color-scheme="dark">
        <CContainer>
            <CNavbarNav class="d-flex flex-md-row flex-grow-1">
                <CCol xs="8" class="d-flex">
                  <CNavItem v-for="item in getItems">
                      <CNavLink
                          @click="go(item)"
                          :disabled="item.current"
                      >
                          {{ item.name }}
                      </CNavLink>
                  </CNavItem>
                </CCol>
                <CCol xs="4" v-if="this.$route.name === 'routes'">
                  <CForm class="d-flex">
                    <CFormInput
                        type="search"
                        v-bind:value="searchQuery"
                        @input="changeSearchQuery"
                        class="me-2"
                        placeholder="Search"
                    />
                    <CButton type="submit" color="light" variant="outline">Search</CButton>
                  </CForm>
                </CCol>
            </CNavbarNav>
        </CContainer>
    </CNavbar>
</template>

<script>
import {
  mapState,
  mapMutations,
} from "vuex";

export default {
    name: "NavBar",
    data() {
        return {
            items: [
                {
                    index: 0,
                    name: 'routes',
                    current: false,
                },
                {
                    index: 1,
                    name: 'stubs',
                    current: false,
                },
                {
                    index: 2,
                    name: 'callbacks',
                    current: false,
                },
            ],
        }
    },
    computed: {
        ...mapState({
          searchQuery: state => state.route.searchQuery,
        }),
        getItems() {
            if (!this.$route.name) {
                return this.items;
            }

            const currentItem = this.items
                .find((item) => item.name === this.$route.name);
            const items = this.items
                .filter((item) => item.index <= currentItem.index);

            return items.map((item, index) => {
               item.current = index === items.length - 1;

               return item;
            });
        }
    },
    methods: {
        ...mapMutations({
          setSearchQuery: 'route/setSearchQuery',
        }),
        changeSearchQuery($event) {
          this.setSearchQuery($event.target.value);
        },
        go(targetItem) {
            if (!targetItem.index) {
                this.$router.push({name: targetItem.name});
            } else {
                this.$router.go(-1);
            }
        }
    }
}
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
