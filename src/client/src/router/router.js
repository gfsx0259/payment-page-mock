import { createRouter, createWebHistory } from "vue-router";
import Routes from "@/pages/Routes";
import Stubs from "@/pages/Stubs";
import Resources from "@/pages/Resources";
import Callbacks from "@/pages/Callbacks";
import {MODULE_ROUTE, MODULE_RESOURCE, MODULE_STUB, MODULE_CALLBACK} from "@/constants";

const routes = [
    {
        path: '/',
        name: MODULE_ROUTE,
        component: Routes
    },
    {
        path: '/resources',
        name: MODULE_RESOURCE,
        component: Resources
    },
    {
        path: '/route/:routeId',
        name: MODULE_STUB,
        component: Stubs
    },
    {
        path: '/route/:routeId/stub/:stubId',
        name: MODULE_CALLBACK,
        component: Callbacks
    },
];

export default createRouter({
    routes,
    history: createWebHistory()
});
