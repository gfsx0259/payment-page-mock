<template>
    <CButton color="dark" @click="onAdd">Add callback</CButton>
    <CRow>
        <CCol md="6" v-for="callback in callbacks">
            <vue-json-editor
                v-bind:value="callback.body"
                @json-save="onUpdate(callback.id, $event)"
                :show-btns="true"
                mode="code"
            />
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
            this.callbacks.push({})
        },
        onUpdate(id, event) {
            this.$emit('update', id, event);
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
.jsoneditor-btns .json-save-btn {
  --cui-btn-bg: #4f5d73;
  background-color: var(--cui-btn-bg, transparent);
  padding: 0.375rem 0.75rem;
}
.jsoneditor-btns .json-save-btn:hover {
  --cui-btn-hover-bg: #697588;
  background-color: var(--cui-btn-hover-bg, transparent);
}
</style>
