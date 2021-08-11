import { read, readOne, car, edit, destroy } from '../Models/Car.js'

export const readCars = element => read(element)

export const readOneCar = (element, id) => readOne(element, id)

export const newCar = element => car(element)

export const editCar = (element, id) => edit(element, id)

export const deleteCar = (element, id) => destroy(id)
