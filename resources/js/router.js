import { createRouter, createWebHistory } from "vue-router";
import Orders from "./components/Orders.vue";

const routes = [
    { path: "/", component: Orders },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
