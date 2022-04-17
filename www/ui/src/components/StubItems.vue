<template>
    <CTable bordered striped>
        <CTableHead>
            <CTableHeaderCell>Title</CTableHeaderCell>
            <CTableHeaderCell>Description</CTableHeaderCell>
            <CTableHeaderCell></CTableHeaderCell>
        </CTableHead>
        <CTableBody>
            <CTableRow v-for="stub in this.stubs">
                <CTableDataCell>{{ stub.title }}</CTableDataCell>
                <CTableDataCell>{{ stub.description }}</CTableDataCell>
                <CTableDataCell>
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
    }
}
</script>
