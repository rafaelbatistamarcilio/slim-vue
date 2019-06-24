import { routes } from './app/Routes.js';
import { App } from './app/App.js';

Vue.use(VueMaterial.default);

const components = { App };
const router = new VueRouter({ routes });
const app = new Vue({ router, components }).$mount('#app');
