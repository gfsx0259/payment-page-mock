<template>
  <CButton color="dark" @click="onAdd">Add callback</CButton>
  <CButton
    class="btn-hint ms-2"
    color="light"
    @click="isHintVisible = !isHintVisible"
  >
    <span class="pe-1">
      <CIcon size="xl" icon="cilCompass" />
    </span>
    <span>Show hint</span>
  </CButton>
  <CallbackHint
    :visible="isHintVisible"
    :dynamicTemplateVariables="dynamicTemplateVariables"
    @hide="isHintVisible = false"
  />
  <CRow>
    <CCol
      md="6"
      v-for="(callback, index) in callbacks"
      :key="callback"
      class="position-relative"
    >
      <callback-editor
        v-bind:value="callback.body"
        v-bind:showMoveLeftControl="Boolean(!hasNewCallback() && index !== 0)"
        v-bind:showMoveRightControl="
          Boolean(!hasNewCallback() && index !== callbacks.length - 1)
        "
        @json-save="onUpdate(callback.id, $event)"
        @json-remove="onRemove(callback.id)"
        @json-move="onMove(callback.id, $event)"
        show-btns
        mode="code"
      />
    </CCol>
  </CRow>
</template>

<script>
import CallbackEditor from "./CallbackEditor";
import CallbackHint from "@/components/CallbackHint";
import { MOVE_LEFT, MOVE_RIGHT } from "@/constants";

export default {
  components: {
    CallbackEditor,
    CallbackHint,
  },
  props: {
    callbacks: {
      type: Array,
      required: true,
    },
    dynamicTemplateVariables: {
      type: Array,
      required: true,
    },
  },
  data: () => {
    return {
      isHintVisible: false,
    };
  },
  methods: {
    onAdd() {
      this.$emit("add");
    },
    onUpdate(id, payload) {
      this.$emit("update", { id, payload });
    },
    onRemove(id) {
      if (confirm("Are you sure?")) {
        this.$emit("remove", id);
      }
    },
    onMove(id, direction) {
      let orderedIds = [];

      for (let i = 0; i < this.callbacks.length; i++) {
        let callback = this.callbacks[i];

        if (callback.id === id) {
          if (direction === MOVE_LEFT) {
            orderedIds.splice(orderedIds.length - 1, 1);
            orderedIds.push(id, this.callbacks[i - 1].id);
          } else if (direction === MOVE_RIGHT) {
            orderedIds.push(this.callbacks[i + 1].id, id);
            i++;
          }
        } else {
          orderedIds.push(callback.id);
        }
      }

      this.$emit("changeOrder", orderedIds);
    },
    hasNewCallback() {
      return this.callbacks.filter(({ id }) => id === null).length !== 0;
    },
  },
};
</script>

<style>
.jsoneditor-menu {
  display: none;
}
.jsoneditor-vue {
  margin-top: 20px;
}
.jsoneditor,
.ace-jsoneditor {
  min-height: 700px;
}
.jsoneditor-btns .json-save-btn,
.json-remove-btn {
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
.btn-hint svg,
.btn-hint span {
  vertical-align: top;
}
.btn-hint svg {
  transition: transform 0.5s;
  -webkit-transition: -webkit-transform 1s;
}
.btn-hint:hover svg {
  transform: rotate(-180deg);
}
</style>
