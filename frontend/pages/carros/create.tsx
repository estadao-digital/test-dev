import Link from 'next/link';
import React, { ChangeEvent, FormEvent, useEffect, useState } from 'react';
import api from '../../services/api';

// import { Container } from './styles';


interface CarsData {
  _id : string,
  marca : string
  modelo : string
  ano : string, 
  message?: string 
}



const create = () => {

  const [message , setMessage] = useState('')
  const [formData , SetFormData] = useState({})


  const getformData = (event : ChangeEvent<HTMLInputElement>) => {
    event.persist()
    SetFormData({ 
      ...formData,
      [event.target.name] : event.target.value
    })
  }

  const addCar = (event : FormEvent) => {
      event.preventDefault()
      api.post(`carros/`, formData)
      .then(success => {
        const {data } = success
        console.log(data)
         setMessage(`carro ${data.modelo} criado com sucesso` )
      }) 
  }


  return (
  <>
   <div style={{'width' : '300px'}}>
    <h2>Adicionar Carro</h2>
    <form onSubmit={addCar}>
      <fieldset>
        <legend>
          marca
        </legend>  
        <input type="text" 
         name="marca" 
         style={{'width' : '100%'}}
          onChange={getformData}
         />
      </fieldset>
      <fieldset>
        <legend>
          modelo
        </legend>  
        <input type="text"   name="modelo" style={{'width' : '100%'}}    onChange={getformData}/>
      </fieldset>
       <fieldset>
        <legend>
          ano
        </legend>  
        <input type="text"  name="ano" style={{'width' : '100%'}}    onChange={getformData}/>
      </fieldset>
        <button
         style={{'width' : '100%' , 'margin' : '20px auto'}}
      >editar</button>

      {message && (
        <>
        <Link href="/">
          <a>voltar</a>
        </Link>
        <br/>
        {message}
        </>
      )}
     </form> 
    </div>
    </>
  );
}




export default create