// useModal.js
import { useState } from 'react';

export function useModal() {
    const [modal, setModal] = useState(null);
    const [currentItem, setCurrentItem] = useState(null);

    const openModal = (type, item = null) => {
        setCurrentItem(item);
        setModal(type);
    };

    const closeModal = () => {
        setCurrentItem(null);
        setModal(null);
    };

    return {
        modal,
        currentItem,
        openModal,
        closeModal,
    };
}
