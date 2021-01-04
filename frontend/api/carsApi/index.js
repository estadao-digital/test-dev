import { HttpClient } from '../../interfaces'

const CARS_API = '/api/cars'

export default {
  takeAll: () => HttpClient.get(CARS_API),
  takeOne: id => HttpClient.get(`${CARS_API}/${id}`),
  createEntry: data => HttpClient.post(CARS_API, data),
  updateEntry: (id, data) => HttpClient.put(`${CARS_API}/${id}`, data),
  removeEntry: id => HttpClient.del(`${CARS_API}/${id}`)
}
