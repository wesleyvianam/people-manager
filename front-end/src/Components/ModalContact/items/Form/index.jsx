import React, { useEffect, useState } from "react";
import { phoneMask } from "../../../../services/phoneMask.js";
import { getData, postData, putData } from "../../../../services/apiService.js";

const Form = ({ closeModal, data, type, fetchData, setMessage, setMessageType }) => {
    const [formData, setFormData] = useState({ contact: '', type: 1, person_id: ''});
    const [people, setPeople] = useState(null);

    const getPeople = async () => {
        const result = await getData('person');
        setPeople(result);

        if (type === 'add') {
            setFormData(prevState => ({ ...prevState, person_id: result[0].id ?? null}));
        }
    };

    const types = {
        'Email': 1,
        'Telefone': 2
    }

    useEffect(() => {
        getPeople();

        if (data) {
            setFormData({ contact: data.contact, type: types[data.type], person_id: data.person.id });
        }
    }, [data]);

    const handleSubmit = async (e) => {
        e.preventDefault();

        const result = type === 'add'
            ? await postData('contact', formData)
            : await putData('contact/' + data.id, formData);

        if (await result) {
            const message = type === 'add'
                ? 'Contato criado com sucesso'
                : 'Contato atualizado com sucesso';

            setMessage(message);
            setMessageType('info');
            fetchData();
            closeModal();
        }
    };

    function handleChange(e) {
        const { name, value } = e.target;

        if (name === "type") {
            setFormData(prevState => ({
                ...prevState,
                type: parseInt(value),
                contact: ""
            }));
        } else if (name === "contact") {
            if (formData.type === 2) {
                setFormData(prevState => ({ ...prevState, [name]: phoneMask(value) }));
            } else {
                setFormData(prevState => ({ ...prevState, [name]: value }));
            }
        } else {
            setFormData(prevState => ({ ...prevState, [name]: value }));
        }
    }

    return (
        <div className="p-3">
            <form onSubmit={(e) => handleSubmit(e, formData)}>
                <div className="flex mb-1">
                    <div className='pe-3 w-1/3'>
                        <label className='block mb-2 text-sm font-medium text-gray-900'>Tipo</label>
                        <select
                            className='block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500'
                            value={formData.type}
                            onChange={handleChange}
                            name="type"
                            required
                        >
                            <option value="1">Email</option>
                            <option value="2">Telefone</option>
                        </select>
                    </div>

                    <div className='w-2/3'>
                        <label className='block mb-2 text-sm font-medium text-gray-900'>{formData.type === 1 ? 'Email' : 'Telefone'}</label>
                        <input
                            type={formData.type === 1 ? 'email' : 'text'}
                            className='bg-gray-50 border text-xs border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5'
                            value={formData.contact}
                            onChange={handleChange}
                            name="contact"
                            required
                        />
                    </div>
                </div>

                <div className='pe-3'>
                    <label className='block mb-2 text-sm font-medium text-gray-900'>Dono do contato</label>
                    <select
                        className='block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500'
                        value={formData.person_id}
                        onChange={handleChange}
                        name="person_id"
                        required
                    >
                        {console.log(formData.person_id)}
                        {people && people.map((person, index) => (
                            <option key={index} value={person.id}>{person.name}</option>
                        ))}
                    </select>
                </div>

                <button className='mt-4 border rounded-md p-2 bg-gray-700 text-white'
                        type='button'
                        onClick={closeModal}>
                    Cancelar
                </button>
                <button className='mt-4 border rounded-md p-2 bg-blue-700 text-white' type='submit'>
                    {type === 'add' ? 'Adicionar' : 'Salvar'}
                </button>
            </form>
        </div>
    )
}

export default Form;
