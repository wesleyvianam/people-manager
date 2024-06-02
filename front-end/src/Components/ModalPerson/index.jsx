import React, { useState, useEffect } from 'react';
import { IoClose } from "react-icons/io5";

import Show from './items/Show';
import Form from "./items/Form/index.jsx";
import Message from "../Message/index.jsx";
import Delete from "./items/Delete/index.jsx";

const ModalPerson = ({
    type,
    item,
    closeModal,
    fetchData,
    message,
    setMessage,
    messageType,
    setMessageType,
    handleClearMessage
}) => {
    return (
        <div className='fixed inset-0 flex items-center justify-center bg-black bg-opacity-50'>
            <div className='bg-white rounded-md w-1/4'>
                <div className='text-xl flex justify-between items-center rounded-t-md font-bold text-white bg-[#e52944]'>
                    <h2 className='px-3'>{type === 'add' ? 'Adicionar Pessoa' : type === 'edit' ? 'Editar Pessoa' : type === 'delete' ? 'Deletar Pessoa' : 'Visualizar Pessoa'}</h2>

                    <button className='text-white hover:bg-[#bb233a] p-2 px-5' type='button' onClick={closeModal}><IoClose /></button>
                </div>

                {(message && messageType === 'error') && <Message type={messageType} message={message} onClose={handleClearMessage} />}

                {type === 'view' && <Show item={item} />}

                {type === 'delete' &&
                    <Delete item={item}
                            closeModal={closeModal}
                            fetchData={fetchData}
                            setMessage={setMessage}
                            setMessageType={setMessageType} />
                }

                {(type === 'add' || type === 'edit') &&
                    <Form closeModal={closeModal}
                          data={item}
                          type={type}
                          fetchData={fetchData}
                          setMessage={setMessage}
                          setMessageType={setMessageType} />
                }
            </div>
        </div>
    );
};

export default ModalPerson;