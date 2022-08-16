<template>
    <CForm>
        <div class="mb-3">
            <CFormLabel for="alias">Alias</CFormLabel>
            <CFormInput type="text" id="alias" :model-value="alias" @input="handleAliasInput" @update:model-value="setAlias"/>
        </div>
        <div class="mb-3">
            <CFormLabel for="path">Path</CFormLabel>
            <CFormInput type="text" id="path" :model-value="path" @update:model-value="setPath"/>
        </div>
        <div class="mb-3">
            <CFormLabel for="description">Description</CFormLabel>
            <CFormInput type="text" id="description" :model-value="description" @update:model-value="setDescription"/>
        </div>
        <div class="mb-3">
            <CFormLabel for="content-type">Content Type</CFormLabel>
            <CFormSelect id="content-type" :model-value="content_type" @update:model-value="setContentType">
                <option value="application/json">application/json</option>
                <option value="application/javascript">application/javascript</option>
            </CFormSelect>
        </div>
        <div class="mb-3">
            <CFormLabel for="content">Content</CFormLabel>
            <CFormTextarea id="content" :model-value="content" @update:model-value="setContent"></CFormTextarea>
        </div>
    </CForm>
</template>

<script>
import {
    mapState,
    mapMutations,
} from 'vuex';

export default {
    methods: {
        ...mapMutations({
            setAlias: 'resource/setAlias',
            setPath: 'resource/setPath',
            setDescription: 'resource/setDescription',
            setContentType: 'resource/setContentType',
            setContent: 'resource/setContent',
        }),
        handleAliasInput(event) {
          console.log(event);
          this.setAlias('');
          return false;
        }
    },
    computed: {
        ...mapState({
            alias: state => state.resource.form.alias,
            path: state => state.resource.form.path,
            description: state => state.resource.form.description,
            content_type: state => state.resource.form.content_type,
            content: state => state.resource.form.content,
        }),
    }
}
</script>
