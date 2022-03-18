<template>
  <form @submit.prevent>
        <input
            v-model="mock.route"
            placeholder="Gate route"
        />

        <div v-for="(callback, index) in mock.callbacks">
            <vue-json-editor
                @json-save="onCallbackEdit(index, $event)"
                v-bind:value="callback"
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
    name: "MockForm",
    props: {
        mock: {
            type: Object
        }
    },
    components: {
      vueJsonEditor,
    },
    methods: {
        onAdd() {
            if (!this.mock.callbacks) {
                this.mock.callbacks = [];
            }

            this.mock.callbacks.push({})
        },
        onCallbackEdit(index, event) {
            this.$emit('updateCallback', index, event);
        },
    },
}
</script>

<style>
form {
  display: flex;
  flex-direction: column;
}

.btn {
  align-self: end;
  margin-top: 15px;
  padding: 15px;
  background: #fff;
  border: 1px solid #0f5132;
}
</style>
