import { createRouter, createWebHistory } from "vue-router";
import LoginComponent from './components/Login.vue';
import RegisterComponent from './components/Register.vue';
import DashboardComponent from './components/Dashboard.vue';
import HomeComponent from './components/Home.vue';
import ProfileComponent from './components/Profile.vue';
import ManageRoleComponent from './components/ManageRole.vue';
import AddUserComponent from './components/AddUser.vue';
import EditUserComponent from './components/EditUser.vue';
import ViewUserComponent from './components/View.vue';
import AddRoleComponent from './components/AddRole.vue';

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
        path: '/users/add',
        name: 'addUser',
        component: AddUserComponent
    },
    {
        path: '/users/edit/:id',
        name: 'editUser',
        component: EditUserComponent,
        props: true,
    },
    {
        path: '/users/view/:id',
        name: 'view',
        component: ViewUserComponent,
        props: true,
    },
    {
        path: '/roles/add',
        name: 'addRole',
        component: AddRoleComponent,
    },

];
const router = createRouter({
    history: createWebHistory(), // Use history mode for clean URLs
    routes,
});
export default router;
