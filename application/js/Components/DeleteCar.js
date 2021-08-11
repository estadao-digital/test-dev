import { deleteCar } from '../Controllers/CarsController.js'

export const DeleteCar = ({id}) => {
    let div = document.createElement('div')
    deleteCar(div, id)
    return div
}
