<template>
    <CButton color="dark" @click="onAdd">Add callback</CButton>
    <CRow>
        <CCol md="6" v-for="callback in callbacks">
            <vue-json-editor
                v-bind:value="callback.body"
                @json-save="onCallbackEdit(callback.id, $event)"
                mode="code"
                :show-btns="true"
                :expandedOnStart="true">
            </vue-json-editor>
        </CCol>
    </CRow>
</template>

<script>
import vueJsonEditor from 'vue-json-editor'

export default {
    name: "CallbackItems",
    props: {
        callbacks: {
            type: Array,
            required: true,
        }
    },
    components: {
        vueJsonEditor,
    },
    methods: {
        onAdd() {
            if (!this.callbacks) {
                this.callbacks = [];
            }

            this.callbacks.push({})
        },
        onCallbackEdit(index, event) {
            this.$emit('updateCallback', index, event);
        },
    },
}
</script>

<style>
.jsoneditor-menu {
    display: none;
}

.jsoneditor-vue {
    margin-top: 20px;
}

.jsoneditor,.ace-jsoneditor {
    min-height: 700px;
}
</style>
