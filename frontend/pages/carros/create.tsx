import { error } from 'console';
import Link from 'next/link';
import React, { ChangeEvent, FormEvent, useEffect, useState } from 'react';
import api from '../../services/api';

// import { Container } from './styles';


const create = () => {

  const [message , setMessage] = useState('')
  const [formData , SetFormData] = useState({})
  const [brand , setBrand] = useState([])

useEffect(() => {
  api.get('marcas').then(success => {
    const {data} = success
    setBrand(data)
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




  const addCar = (event : FormEvent) => {
      event.preventDefault()
      api.post(`carros/`, formData)
      .then(success => {
        const {data } = success
        console.log(data)
         setMessage(`carro ${data.modelo} criado com sucesso` )
      }).catch(error => {
        setMessage(error + 'todos os campos são obrigatórios')
      }) 
  }

console.log(formData)
  return (
  <main>
    <div className="container">

   <div style={{'width' : '300px'}}>
    <h2>Adicionar Carro</h2>
    <form onSubmit={addCar}>
      <fieldset>
        <legend>
          marca
        </legend>  
        <select name="marca" className="form-control" onChange={getSelectData} >
          <option>Selecione uma marca</option>
          {brand.map(marca => <option key={marca[`_id`]}>{marca[`marca`]}</option>)}
        </select>
      </fieldset>
      <fieldset>
        <legend>
          modelo
        </legend>  
        <input type="text" className="form-control"  name="modelo"     onChange={getInputData}/>
      </fieldset>
       <fieldset>
        <legend>
          ano
        </legend>  
        <input type="text" className="form-control"  name="ano"     onChange={getInputData}/>
      </fieldset>
        <button className="btn btn-lg btn-success my-2"
      >Adicionar</button>

      <div className="row">
      {message && (
        <>
        <div className="alert alert-warning" role="alert">
           {message}
        </div>
        <br/>
        <Link href="/">
          <a className="btn btn-link">voltar</a>
        </Link>
        </>

)}
</div>
     </form> 
    </div>
    </div>
    </main>
  );
}




export default create