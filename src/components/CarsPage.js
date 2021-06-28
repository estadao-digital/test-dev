import React, { useEffect, useState } from "react"
import { Link } from "react-router-dom"
import { toast } from 'react-toastify'
import 'react-toastify/dist/ReactToastify.css'

// * * * * * Components * * * * *
import CarsList from "./CarsList"
// * * * * * Store * * * * *
import store from "../stores/carStore"
import { loadCars, deleteCar } from "../actions/carActions"

const CarsPage = () => {
  const [cars, setCars] = useState(store.getCars())

  useEffect(() => {
    store.addChangeListener(onChange)
    if (cars.length === 0) loadCars()
    return () => store.removeChangeListener(onChange)
  },[cars.length])

  function onChange() {
    setCars(store.getCars())
  }

  function handleDelete(carID) {
    deleteCar(carID).then(() => toast.success('Carro deletado!'))
  }

  return (
    <div className="py-5">
      <div className="d-flex justify-content-md-between flex-column flex-md-row">
        <h2>Listagem de carros</h2>
        <Link to="/carro" className="btn btn-primary mb-3">Adicionar carro</Link>
      </div>
      <CarsList cars={cars} onDelete={handleDelete}/>
    </div>
  )
}

export default CarsPage
