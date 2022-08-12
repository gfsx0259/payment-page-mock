import getEnv from "@/utils/env";

/**
 * API URL
 * @type {string}
 */
export const API_URL = getEnv('VUE_APP_API_URL');

export const MODULE_ROUTE = 'route';
export const MODULE_STUB = 'stub';
export const MODULE_CALLBACK = 'callback';

/**
 * Route type - label map
 */
export const ROUTE_TYPE_MAP = [
    { value: 1, label: 'card' },
    { value: 2, label: 'redirect' },
    { value: 3, label: 'QR' },
];

export const CRUD_METHOD_LABEL = {
    POST: 'created',
    GET: 'read',
    PUT: 'updated',
    DELETE: 'deleted',
};
