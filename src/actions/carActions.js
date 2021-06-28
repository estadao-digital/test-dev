import dispatcher from "../appDispatcher"
import * as carApi from "../api/carApi"
import actionTypes from "./actionTypes"

export function saveCar(car) {
  return carApi
    .saveCar(car)
    .then(savedCar => {
      dispatcher.dispatch({
        actionType: car.id ? actionTypes.UPDATE_CAR : actionTypes.CREATE_CAR,
        car: savedCar.data
      })
    })
}

export function loadCars() {
  return carApi
    .getCars()
    .then(cars => {
      dispatcher.dispatch({
        actionType: actionTypes.LOAD_CARS,
        cars: cars.data
      })
    })
}

export function deleteCar(carID) {
  return carApi
    .deleteCar(carID)
    .then(() => {
      dispatcher.dispatch({
        actionType: actionTypes.DELETE_CAR,
        carID
      })
    })
}
