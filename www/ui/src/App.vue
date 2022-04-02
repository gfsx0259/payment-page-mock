<template>
    <div class="app">
        <CNavbar  color-scheme="light" class="bg-light">
            <CContainer>
            <CNavbarNav>
                <CNavItem>
                    <CNavLink href="#" active>
                        <router-link to='/'>
                            Routes
                        </router-link>
                    </CNavLink>
                </CNavItem>
            </CNavbarNav>
            </CContainer>
        </CNavbar>
        <CContainer class="mt-5">
            <router-view/>
        </CContainer>
    </div>
</template>

<script>
import '@coreui/coreui/dist/css/coreui.min.css';

export default {}
</script>

<style>
:root {
    --cui-header-border-width: 0;
}
</style>
