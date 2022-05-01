<template>
    <CNavbar color="dark" color-scheme="dark">
        <CContainer>
            <CNavbarNav class="flex-md-row">
                <CNavItem v-for="item in getItems">
                    <CNavLink
                        @click="go(item)"
                        :disabled="item.current"
                    >
                        {{ item.name }}
                    </CNavLink>
                </CNavItem>
            </CNavbarNav>
        </CContainer>
    </CNavbar>
</template>

<script>
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
