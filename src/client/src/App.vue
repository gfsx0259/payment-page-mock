<template>
    <div class="app">
        <NavBar/>
        <CContainer class="mt-4">
            <router-view/>
        </CContainer>
    </div>
</template>

<script>
import '@coreui/coreui/dist/css/coreui.min.css';
import NavBar from "@/components/common/NavBar";

export default {
    components: {
        NavBar,
    },
}
</script>

<style>
:root {
    --cui-header-border-width: 0;
}
</style>
