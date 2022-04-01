import { createRouter, createWebHistory } from "vue-router";
import Routes from "@/pages/Routes";
import Stubs from "@/pages/Stubs";
import Callbacks from "@/pages/Callbacks";

const routes = [
    {
        path: '/',
        component: Routes
    },
    {
        path: '/route/:id',
        component: Stubs
    },
    {
        path: '/stub/:id',
        component: Callbacks
    },
];

export default createRouter({
    routes,
    history: createWebHistory()
});
