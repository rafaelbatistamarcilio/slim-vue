
import { loadTemplate } from './../../utils/HttpUtils.js';

const props = ['label'];
const render = template => ( { template, props} );

export const Toast =  resolve => {
    loadTemplate('/public/app/components/toast/toast.html', template => resolve(render(template)) )
}