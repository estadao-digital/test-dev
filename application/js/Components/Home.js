import { readCars } from '../Controllers/CarsController.js'

export const Home = () => {
    let div = document.createElement('div')

    let h2 = document.createElement('h2')
    h2.innerHTML = 'Carros'
    div.appendChild(h2)

    let span = document.createElement('span')
    span.innerHTML = 'Lista todos os carros'
    div.appendChild(span)

    readCars(div)

    return div
}
