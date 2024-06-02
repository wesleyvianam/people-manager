import React, { useEffect, useState } from "react";
import { cpfMask } from "../../../../services/cpfMask.js";
import { phoneMask } from "../../../../services/phoneMask.js";
import {getData, postData, putData} from "../../../../services/apiService.js";
import message from "../../../Message/index.jsx";

const Form = ({ closeModal, data, type, fetchData, setMessage, setMessageType }) => {
    const [formData, setFormData] = useState({ name: '', cpf: '', contact: '', type: '' });

    useEffect(() => {
        if (data) {
            setFormData({ name: data.name, cpf: data.cpf });
        }
    }, [data]);

    const handleSubmit = async (e) => {
        e.preventDefault();

        const result = await type === 'add'
            ? postData('person', formData)
            : putData('person/'+data.id, formData);

        if (await result) {
            const message = type === 'add'
                ? 'Pessoa criada com sucesso'
                : 'Pessoa atualizada com sucesso'

            setMessage(message);
            setMessageType('info');
            fetchData();
            closeModal();
        }
    };

    function handleChange(e) {
        const { name, value } = e.target;
        if (name === "cpf") {
            setFormData(prevState => ({ ...prevState, [name]: cpfMask(value) }));
        } else if (name === "type") {
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
                <div className='mb-4'>
                    <label className='block mb-2 text-sm font-medium text-gray-900'>Nome</label>
                    <input
                        type='text'
                        className='w-full p-2 border rounded'
                        value={formData.name}
                        onChange={handleChange}
                        name="name"
                        required
                    />
                </div>
                <div className='mb-4'>
                    <label className='block mb-2 text-sm font-medium text-gray-900'>CPF</label>
                    <input
                        type='text'
                        className='w-full p-2 border rounded'
                        value={formData.cpf}
                        onChange={handleChange}
                        name="cpf"
                        required
                    />
                </div>

                {type === 'add' && (<>
                    <div className='font-bold mb-4'>
                        <h2>Adicionar contato</h2>
                    </div>

                    <div className="flex mb-4">
                        <div className='pe-3 w-1/3'>
                            <label className='block mb-2 text-sm font-medium text-gray-900'>Tipo</label>
                            <select
                                className='w-full p-2 border rounded'
                                value={formData.type}
                                onChange={handleChange}
                                name="type"
                                required
                            >
                                <option value={1}>Email</option>
                                <option value={2}>Telefone</option>
                            </select>
                        </div>
                        <div className='pe-3 w-2/3'>
                            <label className='block mb-2 text-sm font-medium text-gray-900'>{formData.type === 1 ? 'Email' : 'Telefone'}</label>
                            <input
                                type={formData.type === 1 ? 'email' : 'text'}
                                className='w-full p-2 border rounded'
                                value={formData.contact}
                                onChange={handleChange}
                                name="contact"
                                required
                            />
                        </div>
                    </div>
                </>)}

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
