import { loadTemplate } from "./utils/HttpUtils.js";
import { watchToast } from "./services/ToastService.js";
import { watchUnauthorized } from "./services/AuthService.js";

function onUnauthorized(message) {
    this.$router.push('login');
    setTimeout(() => this.message = message, 1000);
    setTimeout(() => this.message = null, 4000);
}

function onToast(message) {
    this.message = message;
    setTimeout(() => this.message = null, 4000)
}

function created() {
    watchToast(onToast.bind(this));
    watchUnauthorized(onUnauthorized.bind(this));
}

const TEMPLATE_URL = '/public/app/App.html';
const data = () => ({ message: null })
const render = template => ({ template, data, created });

export const App = resolve => loadTemplate(TEMPLATE_URL, template => resolve(render(template)));