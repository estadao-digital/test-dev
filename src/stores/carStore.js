import { EventEmitter } from "events"
import dispatcher from "../appDispatcher"
import actionTypes from "../actions/actionTypes"

const CHANGE_EVENT = 'change'
let _cars = []
let _brands = []

class carStore extends EventEmitter {
  addChangeListener(callback) {
    this.on(CHANGE_EVENT, callback)
  }

  removeChangeListener(callback) {
    this.removeListener(CHANGE_EVENT, callback)
  }

  emitChange() {
    this.emit(CHANGE_EVENT)
  }

  getCars() {
    return _cars
  }

  getCarById(id) {
    return _cars.find(car => car.id === parseInt(id, 10))
  }

  getBrands() {
    return _brands
  }
}

const store = new carStore()

dispatcher.register(action => {
  switch (action.actionType) {
    case actionTypes.CREATE_CAR:
      _cars.push(action.car)
      store.emitChange()
      break;

    case actionTypes.LOAD_CARS:
      _cars = action.cars
      store.emitChange()
      break;

    case actionTypes.UPDATE_CAR:
      _cars = _cars.map(car => car.id === action.car.id ? action.car : car)
      store.emitChange()
      break;

    case actionTypes.DELETE_CAR:
      _cars = _cars.filter(car => car.id !== parseInt(action.carID, 10))
      store.emitChange()
      break;

    case actionTypes.LOAD_BRANDS:
      _brands = action.brands
      store.emitChange()
      break;

    default:
      break;
  }
})

export default store
