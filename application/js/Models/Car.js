import { homeView } from '../Views/home.js'
import { carView } from '../Views/car.js'
import { newCarView } from '../Views/newCar.js'
import { editCarView } from '../Views/editCar.js'

export const read = element => {
    fetch('http://localhost:8080/carros')
    .then(response => response.json())
    .then(result => homeView(element, result))
    .catch(err => console.error('Falha ao obter o recurso', err))
}

export const readOne = (element, carId) => {
    carId = window.location.pathname.split('/').pop()
    fetch(`http://localhost:8080/carros/${carId}`)
        .then(response => response.json())
        .then(result => carView(element, result))
        .catch(err => console.error('Falha ao obter o recurso', err))
}

export const car = element => newCarView(element)

export const create = () => {
    const brand = document.querySelector('#brand').value
    const model = document.querySelector('#model').value
    const year = document.querySelector('#year').value

    let data = new URLSearchParams()

    data.append('brand', brand)
    data.append('model', model)
    data.append('year', year)

    if (brand != '' && model != '' && year != '') {
        fetch('http://localhost:8080/carros', {
            method: 'post',
            body: data
        })
        .then(response => response.json())
        .then(json => console.log(json))
        .then(window.router.goTo('/'))
        .catch(err => console.error('Falha ao inserir', err))
    } else {
        console.log('Todos os campos são obrigatórios!')
    }
}

export const edit = (element, carId, result) => {
    carId = window.location.pathname.split('/').pop()
    fetch(`http://localhost:8080/carros/${carId}`)
        .then(response => response.json())
        .then(result => editCarView(element, carId, result))
        .catch(err => console.error('Falha ao obter o recurso', err))
}

export const update = (carId) => {

    const brand = document.querySelector('#brand').value
    const model = document.querySelector('#model').value
    const year = document.querySelector('#year').value

    let data = new URLSearchParams()

    data.append('id', carId)
    data.append('brand', brand)
    data.append('model', model)
    data.append('year', year)

    if (brand != '' && model != '' && year != '') {
        fetch(`http://localhost:8080/carros/${carId}`, {
            method: 'put',
            body: data
        })
        .then(response => response.text())
        .then(text => console.log(text))
        .then(window.router.goTo('/'))
        .catch(err => console.error('Falha ao editar o recurso', err))
    } else {
        console.log('Todos os campos são obrigatórios!')
    }
}

export const destroy = (carId) => {
    carId = window.location.pathname.split('/').pop()
    let areYouShure = confirm('Deseja realmente excluir este carro?');
    if (areYouShure) {
        let data = new URLSearchParams()
        data.append('id', carId)
        fetch(`http://localhost:8080/carros/${carId}`, {
            method: 'delete',
            body: data
        })
        .then(response => response.json())
        .then(json => {
            console.log(json)
            window.router.goTo('/')
        })
        .catch(err => console.error('Falha ao excluir o recurso', err))
    } else {
        window.history.back()
    }
}
