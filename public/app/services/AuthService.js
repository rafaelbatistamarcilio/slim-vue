
export const UNAUTHORIZED_EVENT = 'UNAUTHORIZED_EVENT';
const AUTH_API = '/api/auth';
const USER_STORE = 'USER_INFO';

export const authenticateUser = async credentials => {
    try {
        const response = await axios.post(`${AUTH_API}/login`, credentials);
        localStorage.setItem(USER_STORE, JSON.stringify(response.data));
    } catch (e) {
        throw { message: e.response.data.message }
    }
}

export const isAuthenticated = () => {
    return localStorage.getItem(USER_STORE) != null ? true : false;
}

export const hasRole = requiredRole => {
    if (!isAuthenticated()) return false;
    
    const userInfo = JSON.parse(localStorage.getItem(USER_STORE));
    return userInfo.roles.includes(requiredRole)
}

export const getAuthToken = ()=> localStorage.getItem(USER_STORE) ? JSON.parse(localStorage.getItem(USER_STORE)).token : null;

export const clearToken = ()=> localStorage.removeItem(USER_STORE);

export const watchUnauthorized = callback => PubSub.subscribe(UNAUTHORIZED_EVENT, (message, data) => callback(data));

export const sendUnauthorized = message => PubSub.publish(UNAUTHORIZED_EVENT, message);