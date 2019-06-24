import { loadTemplate } from './../utils/HttpUtils.js';

const state = { teste: 'bind variable' };

const data = () =>  state
const render = template => ({ template, data });

const Home = resolve => {
    loadTemplate('/public/app/pages/home.html', template => resolve(render(template)))
}

export default Home;