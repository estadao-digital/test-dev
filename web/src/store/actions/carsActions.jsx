 import http from 'services/http'
 import * as types from 'types/carsType'

export const getList = () => {
    return dispatch => {
        http.get('/carros')
            .then(response => {
                dispatch([
                    { type: types.CARS_FETCHED, payload: response.data }
                ])
            }, error => {})
    }
}