import {MdDelete} from "react-icons/md";
import React from "react";
import {deleteData} from "../../../../services/apiService.js";


const Delete = ({item, fetchData, setMessage, setMessageType, closeModal}) => {

    const handleDelete = async (id) => {
        try {
            const res = await deleteData(`person/${id}`);
            fetchData();
            closeModal();
            setMessage(res.message);
            setMessageType('success');
        } catch (error) {
            setMessage(error.message);
            setMessageType('error');
        }
    };

    return (
        <div className="p-2">
            <p className='p-1'>Deseja excluir a pessoa <strong>{item.name}</strong></p>

            <button className='mt-4 border rounded-md p-1 px-2 ml-2 bg-gray-700 text-white' type='button'
                    onClick={closeModal}>
                Cancelar
            </button>
            <button
                className='border rounded-md p-1 px-2 bg-red-700 text-white cursor-pointer' title="Deletar"
                onClick={() => handleDelete(item.id)}
            >
                Deletar
            </button>
        </div>
    )
}

export default Delete;