import http from 'services/http'
import * as types from 'types/brandsType'

export const getList = () => {
   return dispatch => {
       http.get('/marcas')
           .then(response => {
               dispatch([
                   { type: types.BRANDS_FETCHED, payload: response.data }
               ])
           }, error => {})
   }
}