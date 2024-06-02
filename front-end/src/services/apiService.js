const apiUrl = 'http://localhost:8080/api/';

const request = async (url, options = {}) => {
    try {
        const response = await fetch(url, options);

        if (!response.ok) {
            const errorData = await response.json();
            const errorMessage = errorData.message || 'Erro desconhecido';
            throw new Error(errorMessage);
        }

        return await response.json();
    } catch (error) {
        throw new Error(error.message);
    }
};

export const getData = async (query = '') => {
    return await request(`${apiUrl}${query}`);
};

export const postData = async (path, data) => {
    return await request(apiUrl + path, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
};

export const putData = async (id, data) => {
    return await request(apiUrl + id, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
};

export const deleteData = async (id) => {
    return await request(apiUrl+id, {
        method: 'DELETE'
    });
};
