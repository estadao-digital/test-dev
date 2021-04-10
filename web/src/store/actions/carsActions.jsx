 import http from 'services/http'
 import * as types from 'types/carsType'
 import { toastr } from 'react-redux-toastr'

export const getList = () => {
    return dispatch => {
        http.get('/carros')
            .then(response => {
                dispatch([
                    { type: types.CARS_FETCHED, payload: response.data }
                ])
            })
            .catch(e => {
                toastr.error('Erro', 'Ocorreu um erro ao listar carros!')
            })

        dispatch([
            { type: types.CARS_SAVE, payload: false }
        ])
    }
}

export const create = data => {    
    return dispatch => {
        http.post('/carros', data)
            .then(response => {
                toastr.success('Sucesso', 'Carro cadastrado com sucesso!')

                dispatch([
                    { type: types.CARS_SAVE, payload: true }
                ])
            })
            .catch(e => {
                toastr.error('Erro', 'Ocorreu um erro ao cadastrar o carro!')

                dispatch([
                    { type: types.CARS_SAVE, payload: e.response.data }
                ])
            })
    }
}