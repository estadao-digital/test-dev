import http from 'services/http'
import * as types from 'types/brandsType'
import { toastr } from 'react-redux-toastr'

export const getList = () => {
   return dispatch => {
       http.get('/marcas')
           .then(response => {
                const list = response.data.data.map(item => {
                    return {
                        value: item.nome,
                        name: item.nome
                    }
                })
            
               dispatch([
                   { type: types.BRANDS_FETCHED, payload: list }
               ])
           })
           .catch(e => {
                toastr.error('Erro', 'Ocorreu um erro ao listar marcas!')
            })
   }
}