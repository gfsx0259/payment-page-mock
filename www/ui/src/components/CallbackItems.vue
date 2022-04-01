<template>
  <form @submit.prevent>
        <div v-for="callback in callbacks">
            <vue-json-editor
                v-bind:value="callback.body"
                @json-save="onCallbackEdit(callback.id, $event)"
                mode="code"
                :show-btns="true"
                :expandedOnStart="true">
            </vue-json-editor>
      </div>

        <button class="btn" @click="onAdd">Добавить колбек</button>
  </form>
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
