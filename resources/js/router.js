import { createRouter, createWebHistory } from "vue-router";
import App from './App.vue';
import LoginComponent from './components/Login.vue';
import RegisterComponent from './components/Register.vue';
const routes = [
    { path: '/', component: App },
    { path: '/login', name: 'login', component: LoginComponent },
    { path: '/register', name: 'register', component: RegisterComponent },
];
const router = createRouter({
    history: createWebHistory(), // Use history mode for clean URLs
    routes,
});
export default router;