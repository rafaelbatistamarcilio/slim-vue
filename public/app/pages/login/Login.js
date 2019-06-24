import { loadTemplate } from "../../utils/HttpUtils.js";
import { authenticateUser } from "../../services/AuthService.js";
import { toast } from "../../services/ToastService.js";

function login() {
    const credencials = this.getCredentials();
    this.autenticate(credencials);
}

function getCredentials() {
    const user = { user: this.user.username, password: this.user.password };
    return user;
}

async function autenticate(credentials) {
    try {
        await authenticateUser(credentials);
        this.$router.push('home');
    } catch (e) {
        toast(e.message);
    }
}

const user = { username: null, password: null }
const data = () => ({ user});
const methods = { login, getCredentials, autenticate };
const render = template => ({ template, data, methods });

export const Login = Vue.component('Login', resolve => {
    loadTemplate('/public/app/pages/login/login.html', template => resolve(render(template)))
})