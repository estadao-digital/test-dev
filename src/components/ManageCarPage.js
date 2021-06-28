import React, { useState, useEffect } from "react"
import { toast } from 'react-toastify'
import 'react-toastify/dist/ReactToastify.css'

// * * * * * Components * * * * *
import CarForm from "./CarForm"
// * * * * * Store * * * * *
import store from "../stores/carStore"
import * as carActions from "../actions/carActions"
import * as brandsActions from "../actions/brandsActions"

const ManageCarPage = (props) => {
  const [errors, setErrors]   = useState({})
  const [cars, setCars] = useState(store.getCars())
  const [car, setCar]   = useState({
    id      : null,
    title   : '',
    year    : '',
    brandId : null
  })
  const [brands, setBrands] = useState(store.getBrands())

  function onChange() {
    setCars(store.getCars())
    setBrands(store.getBrands())
  }

  useEffect(() => {
    store.addChangeListener(onChange)
    const id = props.match.params.id

    if (cars.length === 0) {
      carActions.loadCars()
    } else if (id) {
      setCar(store.getCarById(id))
    }

    if (brands.length === 0) {
      brandsActions.loadBrands()
    }

    return () => store.removeChangeListener(onChange)
  }, [cars.length, brands.length, props.match.params.id])

  function handleChange({target}) {
    setCar({...car, [target.name]: target.value})
  }

  function formIsValid() {
    const _erros = {}

    if (!car.title) _erros.title     = "Modelo é obrigatório"
    if (!car.year) _erros.year       = "Ano é obrigatório"
    if (!car.brandId) _erros.brandId = "Marca é obrigatório"

    setErrors(_erros)

    return Object.keys(_erros).length === 0
  }

  function handleSubmit(event) {
    event.preventDefault()

    if (!formIsValid()) return

    carActions
      .saveCar(car)
      .then(() => {
        props.history.push('/carros')
        toast.success('Carro salvo!')
      })
      .catch(_error => toast.success(_error))
  }

  return (
    <div className="py-5">
      <h2>{car.id ? "Editar" : "Adicionar"} carro</h2>
      <CarForm car={car} brands={brands} errors={errors} onChange={handleChange} onSubmit={handleSubmit}/>
    </div>
  )
}

export default ManageCarPage
