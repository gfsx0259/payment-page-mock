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
                    <router-link :to="'/route/' + routeId + '/stub/' + stub.id">
                        <CButton color="dark">Callbacks</CButton>
                    </router-link>
                </CTableDataCell>
                <CTableDataCell class="text-center">
                    <CIcon
                        icon="cilPencil"
                        size="xl"
                        class="cursor-pointer m-1"
                        @click="edit(stub.id)"
                    />
                    <CIcon
                        icon="cilTrash"
                        size="xl"
                        class="cursor-pointer m-1"
                        @click="remove(stub.id)"
                    />
                </CTableDataCell>
            </CTableRow>
        </CTableBody>
    </CTable>
</template>

<script>
export default {
    props: {
        stubs: {
            type: Array,
            required: true,
        },
        routeId: {
            required: true,
        }
    },
    methods: {
        setDefault(id) {
            this.$emit('setDefault', id);
        },
        remove(id) {
            if (confirm('Are you sure?')) {
                this.$emit('remove', id);
            }
        },
        edit(id) {
            this.$emit('edit', id);
        },
    }
}
</script>

<style scoped>
.active .icon {
    color: darkred;
}
.cursor-pointer {
  cursor: pointer;
}
</style>
