import { createRouter, createWebHistory } from "vue-router";
import LoginComponent from './components/Login.vue';
import RegisterComponent from './components/Register.vue';
import DashboardComponent from './components/Dashboard.vue';
import HomeComponent from './components/Home.vue';
import ProfileComponent from './components/Profile.vue';
import ManageRoleComponent from './components/ManageRole.vue';
import AddUserComponent from './components/AddUser.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeComponent
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: DashboardComponent
    },
    {
        path: '/profile',
        name: 'profile',
        component: ProfileComponent
    },
    {
        path: '/login',
        name: 'login',
        component: LoginComponent
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterComponent
    },
    {
        path: '/manageRole',
        name: 'manageRole',
        component: ManageRoleComponent
    },
    {
        path: '/addUser',
        name: 'addUser',
        component: AddUserComponent
    },
];
const router = createRouter({
    history: createWebHistory(), // Use history mode for clean URLs
    routes,
});
export default router;
