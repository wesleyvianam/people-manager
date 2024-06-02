const Show = ({item}) => {
    return (
        <div className="p-2">
            <p className='p-1'><strong>{item.type}: </strong>{item.contact}</p>
            <p className='p-1'><strong>pessoa: </strong> {item.person.name}</p>
        </div>
    )
}

export default Show;