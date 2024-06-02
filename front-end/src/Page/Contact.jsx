import React, { useState, useEffect } from 'react';
import { MdEdit, MdDelete } from "react-icons/md";
import { FaEye } from "react-icons/fa6";

import Navigation from "../Components/Navigate/index.jsx";
import ModalPerson from "../Components/ModalPerson/index.jsx";
import Message from "../Components/Message/index.jsx";
import { useModal } from "../services/useModal.js";
import { getData } from '../services/apiService';
import ModalContact from "../Components/ModalContact/index.jsx";

function Contact() {
    const [query, setQuery] = useState('');
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(false);
    const {modal, currentItem, openModal, closeModal} = useModal();
    const [message, setMessage] = useState(null);
    const [messageType, setMessageType] = useState(null);

    const fetchData = async (searchQuery = '') => {
        setLoading(true);

        try {
            const result = await getData('contact?search='+searchQuery);
            setData(result);
        } catch (error) {
            setMessage(error.message);
            setMessageType('info');
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchData();
    }, []);

    const handleClearMessage = () => {
        setMessage(null);
        setMessageType(null);
    };

    return (
        <div className='xl:w-4/5 2xl:w-2/3 m-auto'>
            <Navigation query={query} setQuery={setQuery} openModal={openModal} />

            {(message && modal === null) && <Message type={messageType} message={message} onClose={handleClearMessage} />}

            <div>
                {loading && <div>Carregando...</div>}

                {(data && data.length > 0) ? (
                    <div className='px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4'>
                        {data.map((item, index) => (
                            <div className='p-2 rounded-md border' key={index}>
                                <h1 className='text-xl mb-4 font-semibold'>
                                    {item.contact} <br />
                                    <small className='font-medium'>Pessoa: {item.person.name}</small>
                                </h1>

                                <div className='flex justify-between items-end'>
                                    <span className="bg-blue-100 text-blue-800 font-medium me-2 px-2.5 py-0.5 rounded">
                                        {item.type}
                                    </span>

                                    <div className='flex'>
                                        <button
                                            className='border rounded-md p-1 px-2 me-2 cursor-pointer text-gray-800' title="Vizualizar"
                                            onClick={() => openModal('view', item)}
                                        >
                                            <FaEye />
                                        </button>
                                        <button
                                            className='border rounded-md p-1 px-2 me-2 bg-gray-700 text-white cursor-pointer' title="Editar"
                                            onClick={() => openModal('edit', item)}
                                        >
                                            <MdEdit/>
                                        </button>
                                        <button
                                            className='border rounded-md p-1 px-2 bg-red-700 text-white cursor-pointer' title="Deletar"
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
