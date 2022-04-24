<template>
    <CTable bordered striped>
        <CTableHead>
            <CTableHeaderCell class="text-center">
                Default
            </CTableHeaderCell>
            <CTableHeaderCell>
                Title
            </CTableHeaderCell>
            <CTableHeaderCell>
                Description
            </CTableHeaderCell>
            <CTableHeaderCell/>
        </CTableHead>
        <CTableBody>
            <CTableRow v-for="stub in this.stubs">
                <CTableDataCell class="text-center" :class="{active: stub.default}">
                    <CIcon
                        icon="cilFlagAlt"
                        size="xxl"
                        @click="setDefault(stub.id)"
                    />
                </CTableDataCell>
                <CTableDataCell>{{ stub.title }}</CTableDataCell>
                <CTableDataCell>{{ stub.description }}</CTableDataCell>
                <CTableDataCell class="text-center">
                    <router-link :to="'/stub/' + stub.id">
                        <CButton color="dark">Callbacks</CButton>
                    </router-link>
                </CTableDataCell>
            </CTableRow>
        </CTableBody>
    </CTable>
</template>

<script>
export default {
    name: "StubItems",
    props: {
        stubs: {
            type: Array,
            required: true,
        }
    },
    methods: {
        setDefault(id) {
            this.$emit('setDefault', id);
        }
    }
}
</script>

<style scoped>
.active .icon {
    color: darkred;
}
</style>
