<template>
    <CForm>
        <div class="mb-3">
            <CFormLabel for="title">Title</CFormLabel>
            <CFormInput
                :model-value="title"
                @update:model-value="setTitle"
                type="text"
                id="title"
            />
        </div>
        <div class="mb-3">
            <CFormLabel for="description">Description</CFormLabel>
            <CFormTextarea
                :model-value="description"
                @update:model-value="setDescription"
                id="description"
            />
            <CFormText>Any usefully payload</CFormText>
        </div>
    </CForm>
</template>

<script>
import {
    mapState,
    mapMutations,
} from 'vuex';

export default {
    name: "StubForm",
    methods: {
        ...mapMutations({
            setTitle: 'stub/setFormTitle',
            setDescription: 'stub/setFormDescription',
        }),
        create() {
            this.$emit('create', this.stub);
        }
    },
    computed: {
        ...mapState({
            title: state => state.stub.stubForm.title,
            description: state => state.stub.stubForm.description,
        }),
    }
}
</script>
