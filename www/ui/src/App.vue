<template>
    <div class="row">
        <div class="column">
            <MockForm
                v-if="mocks.length"
                :mock="mocks[index]"
                @updateCallback="updateCallback"
            />
        </div>
        <div class="column">
            <MockList
                @select="onSelect"
                :mocks="mocks"
            />
        </div>
    </div>
</template>

<script>
import MockForm from "@/components/MockForm";
import MockList from "@/components/MockList";
import axios from 'axios';

export default {
    components: {
        MockForm,
        MockList,
    },
    data() {
        return {
            index: 0,
            mocks: [],
        }
    },
    async mounted() {
        const response = await axios.get('http://localhost:8082/api/stub');
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

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-color: #1d1b2b;
    color: #fff;
    font-family: Rubik,sans-serif;
}

.row {
    display: flex;
}

.column {
    flex: 30%;
    padding: 50px;
}

.jsoneditor-menu {
    display: none;
}

.jsoneditor-vue {
    margin-top: 20px;
}

.ace-jsoneditor {
    min-height: 400px;
}
</style>
