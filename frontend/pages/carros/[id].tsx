import Link from 'next/link';
import React, { ChangeEvent, FormEvent, useEffect, useState } from 'react';
import api from '../../services/api';

// import { Container } from './styles';


interface CarsData {
  _id : string,
  marca : string
  modelo : string
  ano : string
}



const carros = ({ id }) => {
  const [cars, setCars]  = useState<CarsData>()
  const [message , setMessage] = useState('')
  const [formData , SetFormData] = useState({})

  useEffect(() => {
    api.get(`carros/${id}`).then(success => {
      const {data} = success
      setCars(data)
    })
  },[])

  const getformData = (event : ChangeEvent<HTMLInputElement>) => {
    event.persist()
    SetFormData({ 
      ...formData,
      [event.target.name] : event.target.value
    })
  }

  const sendEdit = (event : FormEvent) => {
      event.preventDefault()
      api.put(`carros/${id}`, formData)
      .then(success => {
        const {data} = success
         setMessage(data[0].message)
      })
  }


  return (
  <>
  {cars && (
   <div style={{'width' : '300px'}}>
    <h2>editar  {cars.modelo}</h2>
    <form onSubmit={sendEdit}>
      <fieldset>
        <legend>
          marca
        </legend>  
        <input type="text" defaultValue={cars.marca} 
         name="marca" 
         style={{'width' : '100%'}}
          onChange={getformData}
         />
      </fieldset>
      <fieldset>
        <legend>
          modelo
        </legend>  
        <input type="text" defaultValue={cars.modelo}  name="modelo" style={{'width' : '100%'}}    onChange={getformData}/>
      </fieldset>
       <fieldset>
        <legend>
          ano
        </legend>  
        <input type="text" defaultValue={cars.ano} name="ano" style={{'width' : '100%'}}    onChange={getformData}/>
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
    )}
    </>
  );
}




export default carros

carros.getInitialProps = ({ query: { id  } }) => {
  return { id }
}