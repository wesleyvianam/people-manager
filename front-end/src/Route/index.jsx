import { BrowserRouter, Routes, Route } from "react-router-dom";
import Person from "../Page/Person.jsx";
import Contact from "../Page/Contact.jsx";

export function RouteApp() {

    return (
        <BrowserRouter>
            <Routes>
                <Route path="/" element={<Person/>} />
                <Route path="/contacts" element={<Contact/>} />
            </Routes>
        </BrowserRouter>
    )
}