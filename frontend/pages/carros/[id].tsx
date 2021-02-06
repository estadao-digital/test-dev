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
  const [brand , setBrand] = useState([])

  useEffect(() => {
    Promise.all([
        api.get(`carros/${id}`),
        api.get('marcas')
    ])
   .then(success => {
      const cars = success[0].data
      const brand = success[1].data
      setCars(cars)
      setBrand(brand)
    })
  },[])

  
  
  
  const getSelectData = (event : ChangeEvent<HTMLSelectElement>) => {
    event.persist()
    SetFormData({ 
      ...formData,
      [event.target.name] : event.target.value
    })  
  } 
  



  const getInputData = (event : ChangeEvent<HTMLInputElement>) => {
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
  <main>
   <div className="container">
  {cars && (
    <div style={{'width' : '300px'}}>
    <h2>editar  {cars.modelo}</h2>
    <form onSubmit={sendEdit}>
      <fieldset>
        <legend>
          marca
        </legend>  
          <select name="marca"  defaultValue={cars.marca}  onChange={getSelectData} className="form-control">
          <option>{cars.marca}</option>
          {brand.map(marca => <option key={marca[`_id`]}>{marca[`marca`]}</option>)}
        </select>
      </fieldset>
      <fieldset>
        <legend>
          modelo
        </legend>  
        <input type="text" defaultValue={cars.modelo}  name="modelo" className="form-control"    onChange={getInputData}/>
      </fieldset>
       <fieldset>
        <legend>
          ano
        </legend>  
        <input type="text" defaultValue={cars.ano} name="ano" className="form-control"    onChange={getInputData}/>
      </fieldset>
        <button
          className="btn btn-lg btn-success my-2"
         >editar</button>

        <div className="row">
      {message && (
        <>
        <div className="alert alert-success" role="alert">
           {message}
        </div>
        <div>

        <Link href="/">
          <a className="btn btn-link">voltar</a>
        </Link>
        </div>
        </>

)}
</div>
     </form> 
    </div>
    )}
    </div> 
    </main>
  );
}




export default carros

carros.getInitialProps = ({ query: { id  } }) => {
  return { id }
}