<template>
  <div class="post" v-for="mock in mocks">
    <div><strong>#{{ mock.id }}</strong></div>
    <div>{{ mock.route }}</div>
    <button @click="onSelect(mock.id)">Выбрать</button>
  </div>
</template>

<script>
export default {
  name: "MockList",
  props: {
    mocks: {
      type: Array,
      required: true
    }
  },
  methods: {
      onSelect (id) {
          this.$emit('select', id)
      }
  },
}
</script>

<style scoped>
.post {
  padding: 15px;
  border: 1px solid #fff;
  margin-top: 15px;
  background-color: #262339;
}
</style>
