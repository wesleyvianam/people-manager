import { Link, useLocation } from "react-router-dom";
import { IoSearch } from "react-icons/io5";
import React from "react";

const Navigation = ({ query, setQuery, openModal }) => {
    const location = useLocation();

    return (
        <nav className="bg-white border-gray-200">
            <div className="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <Link to="/" className="flex items-center space-x-3 rtl:space-x-reverse">
                    <h1 className="self-center text-2xl font-semibold whitespace-nowrap">
                        <span className="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">People</span>Manager
                    </h1>
                </Link>

                <div className="flex md:order-2">
                    <button
                        className='border rounded-md me-3 bg-red-500 text-white pe-3 ps-3'
                        onClick={() => openModal('add')}
                    >
                        Adicionar
                    </button>
                    <div className="relative hidden md:block">
                        <div className="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <i className="w-4 h-4 text-gray-500 dark:text-gray-400"><IoSearch />
                            </i>
                            <span className="sr-only">Search icon</span>
                        </div>
                        <input type="text" id="search-navbar"
                               className="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                               value={query}
                               onChange={(e) => setQuery(e.target.value)}
                               placeholder="Search..."/>
                    </div>
                </div>
                <div className="items-center justify-between hidden w-full md:flex md:w-auto md:order-1"
                     id="navbar-search">
                    <ul className="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
                        <li>
                            <Link to="/"
                                  className={`block py-2 px-3 rounded md:p-0 ${location.pathname === '/' ? 'text-sky-700' : 'text-gray-900'}`}>
                                Pessoas
                            </Link>
                        </li>
                        <li>
                            <Link to="/contacts"
                                  className={`block py-2 px-3 rounded md:p-0 ${location.pathname === '/contacts' ? 'text-sky-700' : 'text-gray-900'}`}>
                                Contatos
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    )
}

export default Navigation;
