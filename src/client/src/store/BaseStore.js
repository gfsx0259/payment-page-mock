import _ from 'lodash'
import Validator from "js-validate";
import HttpClient from "@/network/client";
import { CRUD_METHOD_LABEL } from "@/constants";

export default class BaseStore {
    /**
     * @return string
     */
    endpoint() {
        new Error('Implement endpoint');
    }

    /**
     * Return form validation rules map
     *
     * @return {Object.<string, string|string[]>}
     */
    rules() {
        return {};
    }

    state() {
        return {
            isLoading: false,
            relationId: null,
            entities: [],
            form: {
                id: null,
            },
            invalidFormFields: [],
        }
    }

    mutations() {
        return {
            setIsLoading(state, isLoading) {
                state.isLoading = isLoading;
            },
            setRelationId(state, relationId) {
                state.relationId = relationId;
            },
            setEntities(state, entities) {
                state.entities = entities;
            },
            remove(state, id) {
                const entity = state.entities.find(entity => entity.id === id);
                const index = state.entities.indexOf(entity);

                state.entities.splice(index, 1);
            },
            setFieldInvalid(state, fieldName) {
                state.invalidFormFields.push(fieldName);
            },
            unsetFieldInvalid(state, fieldName) {
                state.invalidFormFields = state.invalidFormFields.filter(
                    invalidFieldName => invalidFieldName !== fieldName
                );
            }
        }
    }

    actions() {
        return {
            fetch: async ({state, commit}) => {
                commit('setIsLoading', true);

                const url = state.relationId ? `${this.endpoint()}/${state.relationId}` : this.endpoint();
                const response = await HttpClient.get(url);

                commit('setEntities', response.data.data);
                commit('setIsLoading', false);
            },
            remove: async ({state, commit, dispatch}, id) => {
                commit('remove', id);

                HttpClient
                    .delete(`${this.endpoint()}/${id}`)
                    .catch(
                        ({response}) => {
                            const data = response.data;

                            commit('setMessage', { text: `Request failed: ${data.error.message}` }, { root: true })
                            dispatch('fetch');
                        }
                    );
            },
            save: async ({state, dispatch}) => {
                dispatch('validate');

                if (state.invalidFormFields.length) {
                    return false;
                }

                dispatch('request', {
                    method: state.form.id ? 'PUT' : 'POST',
                    data: Object.assign(state.form, state.relationId ? { relationId: state.relationId } : {}),
                });

                return true;
            },
            validate: ({state, commit}) => {
                const validator = new Validator();

                Object.entries(this.rules())
                    .map(config => {
                        const field = config[0];
                        const rule = config[1];

                        validator(state.form[field], rule)
                            ? commit('unsetFieldInvalid', field)
                            : commit('setFieldInvalid', field);
                    });
            },
            /**
             * @private
             */
            request: async ({commit, dispatch}, config) => {
                try {
                    config = Object.assign(config, {
                        url: this.endpoint(),
                    });

                    await HttpClient.request(config);

                    dispatch('fetch');

                    commit('setMessage', { text: this.buildSuccessMessage(config.method) }, { root: true });
                } catch (error) {
                    commit('setMessage', { text: error }, { root: true })
                }
            },
        }
    }

    /**
     * @private
     */
    buildSuccessMessage(httpMethod) {
        return `${_.upperFirst(this.endpoint())} ${CRUD_METHOD_LABEL[httpMethod]} successfully`
    }

    getModule() {
        return {
            state: this.state(),
            mutations: this.mutations(),
            actions: this.actions(),
            namespaced: true,
        }
    }
}
