import { lazyLoad } from './utils/HttpUtils.js';
import { Login } from './pages/login/Login.js';
import { isAuthenticated } from './services/AuthService.js';
import { toast } from './services/ToastService.js';

const Home = resolve => lazyLoad('Home.js', resolve);
const Admin = resolve => lazyLoad('admin/Admin.js', resolve);

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
            } else {
                next();
            }
        }
    }
]