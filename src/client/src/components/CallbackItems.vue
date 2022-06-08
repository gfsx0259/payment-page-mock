<template>
  <CButton color="dark" @click="onAdd">Add callback</CButton>
  <CRow>
    <CCol md="6" v-for="callback in callbacks">
      <vue-json-editor
        v-bind:value="callback.body"
        @json-save="onUpdate(callback.id, $event)"
        @json-remove="onRemove(callback.id)"
        :show-btns=true
        mode="code"
      />
    </CCol>
  </CRow>
</template>

<script>
import vueJsonEditor from 'vue-json-editor'

export default {
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
      this.$emit('add');
    },
    onUpdate(id, callback) {
      this.$emit('update', { id, callback });
    },
    onRemove(id) {
      if (confirm('Are you sure?')) {
        this.$emit('remove', id);
      }
    }
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
.jsoneditor-btns .json-save-btn,.json-remove-btn {
  padding: 0.375rem 0.75rem;
  border: none;
  color: #fff;
  border-radius: 5px;
}
.jsoneditor-btns .json-save-btn {
  background-color: #4f5d73;
}
.jsoneditor-btns .json-save-btn:hover {
  background-color: #697588;
}

.jsoneditor-btns .json-remove-btn {
  background-color: #e55353;
}
.jsoneditor-btns .json-remove-btn:hover {
  background-color: #e96d6d;
}
</style>
