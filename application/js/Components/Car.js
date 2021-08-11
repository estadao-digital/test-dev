import { readOneCar } from '../Controllers/CarsController.js'

export const Car = ({id}) => {
    let div = document.createElement('div')

    let h2 = document.createElement('h2')
    h2.innerHTML = 'Carro'
    div.appendChild(h2)

    let span = document.createElement('span')
    span.innerHTML = 'Exibe um carro específico'
    div.appendChild(span)

    readOneCar(div, id)

    return div
}
