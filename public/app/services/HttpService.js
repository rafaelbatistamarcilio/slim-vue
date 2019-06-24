import { clearToken, getAuthToken, sendUnauthorized } from "./AuthService.js";

export const get = async uri => {
    try {
        const header = getAuthHeader();
        const response = await axios.get(uri, header);
        return response.data;
    } catch (e) {
        if (e.response.status == 401) {
            clearToken();
            sendUnauthorized('User not authenticated');
        }
        throw { message: e.response.data.message };
    }
}

export const deleteItem = async uri => {
    try {
        const header = getAuthHeader();
        const response = await axios.delete(uri,header);
        return response.data;
    } catch (e) {
        if (e.response.status == 401) {
            clearToken();
            sendUnauthorized('User not authenticated');
        }
        throw { message: e.response.data.message };
    }
}

const getAuthHeader = () => {
    const token = getAuthToken();

    if (!token) return {};

    const config = { headers: { Authorization: `Bearer ${token}` } };
    return config;
}