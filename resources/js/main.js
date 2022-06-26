import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import App from './App';
import Details from "./components/Details";
import 'antd/dist/antd.css';
import './app.css';

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
    <BrowserRouter>
        <Routes>
            <Route path="/" element={<App />} />
            <Route path="details">
                <Route path=":id" element={<Details />} />
            </Route>
        </Routes>
    </BrowserRouter>
);
