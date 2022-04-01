<template>
    <RouteItems
        @select="onSelect"
        :mocks="mocks"
    />
</template>

<script>
import axios from 'axios';
import RouteItems from '@/components/RouteItems';

export default {
    components: {
        RouteItems,
    },
    data() {
        return {
            index: 0,
            mocks: [],
        }
    },
    async mounted() {
        const response = await axios.get('http://localhost:8082/api/route');
        this.mocks = response.data.data;
    },
    methods: {
        updateCallback(index, callback) {
            axios.post('http://localhost:8082/api/stub/callback', {
                index,
                callback
            })
        },
        onSelect(id) {
            this.index = id - 1;
        },
    },
}
</script>
