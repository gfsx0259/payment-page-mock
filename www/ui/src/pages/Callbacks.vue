<template>
   <CallbackItems
       :callbacks="callbacks"
       @updateCallback="updateCallback"
   />
</template>

<script>
import axios from 'axios';
import CallbackItems from "@/components/CallbackItems";

export default {
    components: {
        CallbackItems,
    },
    data() {
        return {
            callbacks: [],
        }
    },
    async mounted() {
        const response = await axios.get('http://localhost:8082/api/callback');
        this.callbacks = response.data.data;
    },
    methods: {
        updateCallback(index, callback) {
            axios.post('http://localhost:8082/api/stub/callback', {
                index,
                callback
            })
        },
    }
}
</script>
