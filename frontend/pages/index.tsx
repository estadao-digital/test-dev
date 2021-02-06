import Link from 'next/link'
import { useEffect, useState } from 'react'
import api from '../services/api'



interface CarsData {
  _id : string,
  marca : string
  modelo : string
  ano : string
}


const IndexPage = () => {
  const [cars, setCars]  = useState<CarsData[]>()
  const [message, setMessage] = useState('');
  useEffect(() => {
    api.get<CarsData[]>('/carros')
    .then(success => {
      const {data} = success
      setCars(data)
    })
  },[])

  const deleteCar = async (id : string) => {
      await api.delete(`carros/${id}`).then(success =>  {
        console.log(success)
        setCars(cars && cars.filter(car => car._id !== id))
        setMessage(success.data.message)

        setTimeout(() => {
          setMessage('')
        }, 3000)
      })
  }


  return(
    <main>
      <h1>Estadão car</h1>
      <table>
       <thead>
         <tr>

        <th>ID</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Ano</th>
        <th>Editar</th>
        <th>deletar</th>
         </tr>
      </thead>
      <tbody>
        {cars && cars.map(car => {
          return(
            <tr key={car._id}>
                <td>
                 {car._id}
              </td>
              <td>
                 {car.marca}
              </td>
                <td>
                 {car.modelo}
              </td>
              <td>
               {car.ano}
              </td>
                <td>
                  <Link href={`carros/${car._id}`}>
                      <a>Editar</a>
                  </Link>
              </td>
               <td>
                  <button onClick={() => deleteCar(car._id)}>Deletar</button>
              </td>
            </tr>
          )
        })}
        </tbody>
      </table>
      {message}
    </main>
)
}

export default IndexPage
