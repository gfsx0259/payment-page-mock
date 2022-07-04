<template>
  <CButton color="dark" @click="onAdd">Add callback</CButton>
  <CRow>
    <draggable
        v-model="callbacks"
        @start="drag=true"
        @end="drag=false"
        item-key="id"
        tag="CRow"
    >
      <template #item="{element}">
        <CCol md="6" class="position-relative">
          <vue-json-editor
              v-bind:value="element.body"
              @json-save="onUpdate(element.id, $event)"
              @json-remove="onRemove(element.id)"
              show-btns
              mode="code"
          />
          <CIcon
              class="icon-move"
              icon="cilCursorMove"
              size="xl"
          />
        </CCol>
      </template>
    </draggable>
  </CRow>
</template>

<script>
import vueJsonEditor from 'vue-json-editor'
import draggable from 'vuedraggable';

export default {
  props: {
    callbacks: {
      type: Array,
      required: true,
    }
  },
  components: {
    vueJsonEditor,
    draggable
  },
  data() {
    return {
      drag: false,
    }
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
.icon-move {
  position: absolute;
  cursor: pointer;
  bottom: 6px;
  right: 224px;
}
</style>
