import { createRouter, createWebHistory } from "vue-router";
import LoginComponent from './components/Login.vue';
import RegisterComponent from './components/Register.vue';
import DashboardComponent from './components/Dashboard.vue';
import ManageRoleComponent from './components/ManageRole.vue';
import AddUserComponent from './components/AddUser.vue';
import EditUserComponent from './components/EditUser.vue';
import ViewUserComponent from './components/View.vue';
import ForbiddenComponent from './components/Forbidden.vue';

const routes = [
    {
        path: '/dashboard',
        name: 'dashboard',
        component: DashboardComponent,
        meta: { requiresAuth: true },
    },
    {
        path: '/',
        name: 'login',
        component: LoginComponent,
        meta: { requiresAuth: false },
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterComponent,
        meta: { requiresAuth: false },
    },
    {
        path: '/manageRole',
        name: 'manageRole',
        component: ManageRoleComponent,
        meta: { requiresAuth: true },
    },
    {
        path: '/users/add',
        name: 'addUser',
        component: AddUserComponent,
        meta: { requiresAuth: true },
    },
    {
        path: '/users/edit/:id',
        name: 'editUser',
        component: EditUserComponent,
        props: true,
        meta: { requiresAuth: true },
    },
    {
        path: '/users/view/:id',
        name: 'view',
        component: ViewUserComponent,
        props: true,
        meta: { requiresAuth: true },
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'forbidden',
        component: ForbiddenComponent,
    },
];
const router = createRouter({
    history: createWebHistory(), // Use history mode for clean URLs
    routes,
});

router.beforeEach((to, from, next) => {
    let loginUser = null;
    try {
        loginUser = JSON.parse(localStorage.getItem('user'));
    } catch (error) {
        console.log('Failed to fetch login user:', error);
    }

    // no token and no user
    if (to.meta.requiresAuth && !loginUser) {
        next({ name: 'login' });

    // already log in and register
    } else if((to.name === 'login' || to.name === 'register') && loginUser) {
        next({ name: 'dashboard' })

    // except admins can't go to manage role page
    } else if(to.name === 'manageRole' && loginUser.role_id !== 3 && loginUser) {
        next({ name: 'dashboard'})
    } else {
        next();
    }
})

export default router;
