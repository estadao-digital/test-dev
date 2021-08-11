import { editCar } from '../Controllers/CarsController.js'

export const EditCar = ({id}) => {
    let div = document.createElement('div')

    let h2 = document.createElement('h2')
    h2.innerHTML = 'Editar Carro'
    div.appendChild(h2)

    let span = document.createElement('span')
    span.innerHTML = 'Edita um carro'
    div.appendChild(span)

    editCar(div, id)

    return div
}
