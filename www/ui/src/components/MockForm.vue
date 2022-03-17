<template>
  <form @submit.prevent>
        <input
            v-model="mock.route"
            placeholder="Gate route"
        />
        <vue-json-editor
            v-for="callback in mock.callbacks"
            v-bind:value="callback"
            mode="code"
            :show-btns="false"
            :expandedOnStart="true">
        </vue-json-editor>

        <button class="btn" @click="onAdd">Добавить колбек</button>
        <button class="btn" @click="onSave">Сохранить</button>
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
        onSave() {
            this.$emit('create', this.mock);
        }
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
