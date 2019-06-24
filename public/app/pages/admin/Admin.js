import { deleteItem } from '../../services/HttpService.js';
import { toast } from '../../services/ToastService.js';
import { loadTemplate } from '../../utils/HttpUtils.js';

const state = { message: null };

const USER_API = '/api/user';
const TEMPLATE_URL = '/public/app/pages/admin/Admin.html';

async function deleteUser() {
    try {
        const response = await deleteItem(`${USER_API}/35`);
        toast('User deleted!');
        this.message = response.message;
    } catch (e) {
        toast(e.message)
    }
}

const methods = { deleteUser }

const data = () =>  state
const render = template => ({ template, data , methods});

const Admin = resolve => {
    loadTemplate(TEMPLATE_URL, template => resolve(render(template)))
}

export default Admin;