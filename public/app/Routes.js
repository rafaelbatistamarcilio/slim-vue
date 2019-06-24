import { lazyLoad } from './utils/HttpUtils.js';
import { Login } from './pages/login/Login.js';
import { isAuthenticated, hasRole } from './services/AuthService.js';
import { toast } from './services/ToastService.js';
import Constants from './config/Constants.js';

const Home = resolve => lazyLoad('Home.js', resolve);
const Admin = resolve => lazyLoad('admin/Admin.js', resolve);
const User = resolve => lazyLoad('user/User.js', resolve);


export const routes = [
    {
        path: '/',
        beforeEnter: (to, from, next) => {
            if (isAuthenticated()) {
                next('home');
            } else {
                next('login');
            }
        }
    },
    {
        path: '/login',
        component: Login,
        beforeEnter: (to, from, next) => {
            if (isAuthenticated()) {
                next('/home');
            } else {
                next();
            }
        }
    },
    {
        path: '/home',
        component: Home,
        beforeEnter: (to, from, next) => {
            if (!isAuthenticated()) {
                toast('User Not Authenticated');
                next('/login');
            } else {
                next();
            }
        }
    },
    {
        path: '/admin',
        component: Admin,
        beforeEnter: (to, from, next) => {
            if (!isAuthenticated()) {
                toast('User Not Authenticated');
                next('/login');
            } else if (!hasRole(Constants.USER.W)) {
                toast('No permition to access the page');
                next('/home');
            } else {
                next();
            }
        }
    },
    {
        path: '/user',
        component: User,
        beforeEnter: (to, from, next) => {
            if (!isAuthenticated()) {
                toast('User Not Authenticated');
                next('/login');
            } else if (!hasRole(Constants.USER.R)) {
                toast('No permition to access the page');
                next('/home');
            } else {
                next();
            }
        }
    }
]