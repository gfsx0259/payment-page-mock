<template>
    <CModal :visible="visible" @close="hideModal">
        <CModalHeader :close-button="false">
            <CModalTitle>{{ title }}</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <slot></slot>
        </CModalBody>
        <CModalFooter>
            <CButton color="secondary" @click="hideModal">
                Close
            </CButton>
            <CButton color="primary" @click="save">Save</CButton>
        </CModalFooter>
    </CModal>
</template>

<script>


export default {
    name: "Modal",
    props: {
        visible: {
            type: Boolean,
            default: false,
            required: true,
        },
        title: {
            type: String,
            required: true,
        },
        saveCallback: {
            type: Function,
            required: true,
        }
    },
    methods: {
        hideModal() {
            this.$emit('update:visible', false);
        },
        save() {
            this.saveCallback();
            this.hideModal();
        },
    }
}
</script>
