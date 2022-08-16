import BaseStore from "@/store/BaseStore";
import {MODULE_RESOURCE} from "@/constants";

export default class ResourceStore extends BaseStore {
    endpoint() {
        return MODULE_RESOURCE;
    }

    state() {
        return {
            ...super.state(),
            form: {
                id: null,
                alias: '',
                path: '',
                description: '',
                content_type: 'application/json',
                content: '',
            },
        }
    }

    mutations() {
        return {
            ...super.mutations(),
            setAlias(state, value) {
                state.form.alias = value;
            },
            setPath(state, value) {
                state.form.path = value;
            },
            setDescription(state, value) {
                state.form.description = value;
            },
            setContentType(state, value) {
                state.form.content_type = value;
            },
            setContent(state, value) {
                state.form.content = value;
            },
            loadFormByResource(state, id) {
                const resource = state.entities.find(resource => resource.id === id);

                state.form.id = resource.id;
                state.form.alias = resource.alias;
                state.form.path = resource.path;
                state.form.description = resource.description;
                state.form.content_type = resource.content_type;
                state.form.content = resource.content;
            },
            cleanForm(state) {
                state.form.id = null;
                state.form.alias = '';
                state.form.path = '';
                state.form.description = '';
                state.form.content_type = 'application/json';
                state.form.content = '';
            },
        }
    }

    actions() {
        return {
            ...super.actions(),
        }
    }
}
