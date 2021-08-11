import { newCar } from '../Controllers/CarsController.js'

export const NewCar = () => {
    const div = document.createElement('div')

    let h2 = document.createElement('h2')
    h2.innerHTML = 'Novo Carro'
    div.appendChild(h2)

    let span = document.createElement('span')
    span.innerHTML = 'Insere um novo carro'
    div.appendChild(span)

    newCar(div)

    return div
}
