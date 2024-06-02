const Show = ({item}) => {
    return (
        <div className="p-2">
            <p className='p-1'><strong>Nome:</strong> {item.name}</p>
            <p className='p-1'><strong>CPF:</strong> {item.cpf}</p>
            <p className='p-1'><strong>Contatos:</strong></p>
            {item.contacts && item.contacts.length > 0 ? (
                item.contacts.map((contact, index) => (
                    <p  className='p-1' key={index}>
                        <strong>{contact.type}: </strong>
                        {contact.contact}
                    </p>
                ))
            ) : (
                <i className='px-1 text-gray-700'>Nenhum contato cadastrado</i>
            )}
        </div>
    )
}

export default Show;