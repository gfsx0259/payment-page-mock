<template>
  <CBadge v-if="type" :color="this.getColor()">{{ this.getLabel() }}</CBadge>
</template>

<script>
import { ROUTE_TYPE_MAP } from "@/constants";

export default {
  props: {
    type: {
      type: Number,
      required: true,
    },
  },
  methods: {
    getColor() {
      switch (this.type) {
        case 1:
          return "danger";
        case 2:
          return "warning";
        case 3:
          return "success";
      }
    },
    getLabel() {
      const type = ROUTE_TYPE_MAP.find((type) => type.value === this.type);
      return type ? type.label : "";
    },
  },
};
</script>

<style scoped>
.badge {
  position: absolute;
  top: 0;
  left: 0;
  border-radius: 5px 0 5px 0;
}
</style>
