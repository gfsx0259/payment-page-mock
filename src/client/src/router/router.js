import { createRouter, createWebHistory } from "vue-router";
import Routes from "@/pages/Routes";
import Stubs from "@/pages/Stubs";
import Callbacks from "@/pages/Callbacks";

const routes = [
    {
        path: '/',
        name: 'routes',
        component: Routes
    },
    {
        path: '/route/:id',
        name: 'stubs',
        component: Stubs
    },
    {
        path: '/stub/:id',
        name: 'callbacks',
        component: Callbacks
    },
];

export default createRouter({
    routes,
    history: createWebHistory()
});
