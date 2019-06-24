import { get } from '../../services/HttpService.js';
import { toast } from '../../services/ToastService.js';
import { loadTemplate } from '../../utils/HttpUtils.js';

const state = { username: null };

const USER_API = '/api/user';
const TEMPLATE_URL = '/public/app/pages/user/User.html';

async function loadUser() {
    try {
        const response = await get(`${USER_API}/35`);
        this.username = response.name;
        toast('User loaded!');
    } catch (e) {
        toast(e.message)
    }
}

const methods = { loadUser };

const data = () =>  state
const render = template => ({ template, data , methods});

const User = resolve => {
    loadTemplate(TEMPLATE_URL, template => resolve(render(template)))
}

export default User;