 import http from 'services/http'
 import * as types from '../types/carsType'

export function getList() {
    const request = http.get(`${API_URL}/carros`)
    
    return {
        type: types.CARS_FETCHED,
        payload: request
    }
}