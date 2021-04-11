 import http from 'services/http'
 import * as types from 'types/carsType'
 import { toastr } from 'react-redux-toastr'
 import { reset as resetForm, initialize } from 'redux-form'

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

const save = (data, type) => {
    const handleProperty = {
        create: {
            action: 'post',
            messageSuccess: 'Carro cadastrado com sucesso!',
            messageError: 'Ocorreu um erro ao cadastrar o carro!',
            url: '/carros'
        },
        update: {
            action: 'put',
            messageSuccess: 'Carro alterado com sucesso!',
            messageError: 'Ocorreu um erro ao alterar o carro!',
            url: `/carros/${data.id}`
        }
    }

    return dispatch => {
        http[handleProperty[type].action](handleProperty[type].url, data)
            .then(response => {
                toastr.success('Sucesso', handleProperty[type].messageSuccess)

                dispatch([
                    { type: types.CARS_SAVE, payload: true }
                ])
            })
            .catch(e => {
                toastr.error('Erro', handleProperty[type].messageError)

                dispatch([
                    { type: types.CARS_SAVE, payload: e.response.data }
                ])
            })
    }
}

export const create = data => {    
    return save(data, 'create')
}

export const update = data => {    
    return save(data, 'update')
}

export const view = id => {  
    return http.get(`/carros/${id}`)
        .then(response => {
            const data = response.data.data

            if (data.length <= 0) toastr.error('Erro', 'Ocorreu um erro ao tentar recuperar o veículo!')
            
            return [
                initialize('carsForm', data)
            ]
        })
        .catch(e => {
            toastr.error('Erro', 'Ocorreu um erro ao tentar recuperar o veículo!')
        })
}