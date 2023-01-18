import React from 'react';
import ReactDOM from 'react-dom/client';
import {BrowserRouter, Routes, Route} from 'react-router-dom';
import reportWebVitals from './reportWebVitals';

import 'bootstrap/dist/css/bootstrap.min.css';

import {Home} from './pages/Home'
import {Mantenedor} from './pages/Mantenedor'
import {MantenedorCentros} from './pages/MantenedorCentros'
import {MantenedorFarmacias} from './pages/MantenedorFarmacias'
import {MantenedorMedicamentos} from './pages/MantenedorMedicamentos'


export default function App(){
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/mantenedor" element={<Mantenedor/>}>
          <Route path="centros" element={<MantenedorCentros/>}/>
          <Route path="farmacias" element={<MantenedorFarmacias/>}/>
          <Route path="medicamentos" element={<MantenedorMedicamentos/>}/>
        </Route>
        <Route path="/" element={<Home/>}>

        </Route>
      </Routes>
    </BrowserRouter>
  );
}

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(<App/>);
