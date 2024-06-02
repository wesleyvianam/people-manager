import React, { useState, useEffect } from 'react';
import { MdEdit, MdDelete } from "react-icons/md";
import { FaEye } from "react-icons/fa6";

import Navigation from "../Components/Navigate/index.jsx";
import Message from "../Components/Message/index.jsx";
import { useModal } from "../services/useModal.js";
import { getData } from '../services/apiService';
import ModalContact from "../Components/ModalContact/index.jsx";

function Contact() {
    const [query, setQuery] = useState('');
    const [data, setData] = useState(null);
    const {modal, currentItem, openModal, closeModal} = useModal();
    const [message, setMessage] = useState(null);
    const [messageType, setMessageType] = useState(null);
    const [people, setPeople] = useState(null);
    const [selectedPerson, setSelectedPerson] = useState('');
    const [selectedType, setSelectedType] = useState('');

    const getPeople = async () => {
        const result = await getData('person');
        setPeople(result);
    };

    const fetchData = async (searchQuery = '', person = '', type = '') => {
        try {
            const queryParams = new URLSearchParams({
                search: searchQuery,
                person_id: person,
                type: type
            });

            const result = await getData('contact?' + queryParams.toString());
            setData(result);
        } catch (error) {
            setMessage(error.message);
            setMessageType('info');
        }
    };

    useEffect(() => {
        fetchData();
        getPeople();
    }, []);

    const handleClearMessage = () => {
        setMessage(null);
        setMessageType(null);
    };

    const handlePersonChange = (e) => {
        const personId = e.target.value;
        setSelectedPerson(personId);
        fetchData(query, personId, selectedType);
    };

    const handleTypeChange = (e) => {
        const type = e.target.value;
        setSelectedType(type);
        fetchData(query, selectedPerson, type);
    };

    const handleQueryChange = (e) => {
        const query = e.target.value;
        setQuery(query);
        fetchData(query, selectedPerson, selectedType);
    };

    return (
        <div className='xl:w-4/5 2xl:w-2/3 m-auto'>
            <Navigation query={query} setQuery={setQuery} openModal={openModal} />

            {(message && modal === null) && <Message type={messageType} message={message} onClose={handleClearMessage} />}

            <div>
                <div className="mx-4 border mb-4 p-3 rounded-md flex">
                    <div className='pe-3 w-3/12'>
                        <label className='block mb-2 text-sm font-medium text-gray-900'>Buscar</label>
                        <input
                            className='block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500'
                            name="person_id"
                            required
                            value={query}
                            placeholder='Search...'
                            onChange={handleQueryChange}
                        />
                    </div>
                    <div className='pe-3 w-3/12'>
                        <label className='block mb-2 text-sm font-medium text-gray-900'>Pessoa</label>
                        <select
                            className='block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500'
                            name="person_id"
                            required
                            value={selectedPerson}
                            onChange={handlePersonChange}
                        >
                            <option value="">Selecionar</option>
                            {people && people.map((person, index) => (
                                <option key={index} value={person.id}>{person.name}</option>
                            ))}
                        </select>
                    </div>

                    <div className='pe-3 w-2/12'>
                        <label className='block mb-2 text-sm font-medium text-gray-900'>Tipo</label>
                        <select
                            className='block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500'
                            name="type"
                            required
                            value={selectedType}
                            onChange={handleTypeChange}
                        >
                            <option value="">Selecionar</option>
                            <option value="1">Email</option>
                            <option value="2">Telefone</option>
                        </select>
                    </div>
                </div>

                {(data && data.length > 0) ? (
                    <div className='px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4'>
                        {data.map((item, index) => (
                            <div className='p-2 rounded-md border' key={index}>
                                <h1 className='text-xl mb-4 font-semibold'>
                                    {item.contact} <br/>
                                    <small className='font-medium'>Pessoa: {item.person.name}</small>
                                </h1>

                                <div className='flex justify-between items-end'>
                                    <span className="bg-blue-100 text-blue-800 font-medium me-2 px-2.5 py-0.5 rounded">
                                        {item.type}
                                    </span>

                                    <div className='flex'>
                                        <button
                                            className='border rounded-md p-1 px-2 me-2 cursor-pointer text-gray-800'
                                            title="Vizualizar"
                                            onClick={() => openModal('view', item)}
                                        >
                                            <FaEye/>
                                        </button>
                                        <button
                                            className='border rounded-md p-1 px-2 me-2 bg-gray-700 text-white cursor-pointer'
                                            title="Editar"
                                            onClick={() => openModal('edit', item)}
                                        >
                                            <MdEdit/>
                                        </button>
                                        <button
                                            className='border rounded-md p-1 px-2 bg-red-700 text-white cursor-pointer'
                                            title="Deletar"
                                            onClick={() => openModal('delete', item)}
                                        >
                                            <MdDelete/>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                ) : (
                    <div className="p-2 mx-4 rounded-md border">
                        <p className="font-semibold text-gray-800">Nenhum contato encontrado</p>
                    </div>
                )}
            </div>

            {
                modal && (
                    <ModalContact type={modal}
                                  item={currentItem}
                                  closeModal={closeModal}
                                  fetchData={fetchData}
                                  message={message}
                                  setMessage={setMessage}
                                  messageType={messageType}
                                  setMessageType={setMessageType}
                                  handleClearMessage={handleClearMessage}
                    />
                )
            }
        </div>
    );
}

export default Contact;
