import axios from "axios";

axios.defaults.headers["Accept"] = "application/ld+json";
axios.defaults.headers["Content-Type"] = "application/json";

export const jsonLdFetch = async(url, method = 'GET', data = null, token = null) => {

    const options = {
        method: method,
        url: url
    };

    if (token) {
        axios.defaults.headers["Authorization"] = "Bearer " + token;
    }

    if (data) {
        axios.defaults.data = data;
    }

    const response = await axios(options);

    if (response.status === 204) {
        return null;
    }

    if (response.status === 200) {
        return response.data;
    } else {
        throw response
    }
}