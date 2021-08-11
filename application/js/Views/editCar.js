import { update } from '../Models/Car.js'

export const editCarView = (element, carId, data) => {
    const carsBrand = [
        'Agrale',
        'Audi',
        'BMW',
        'BYD',
        'CAOA Chery',
        'Chevrolet',
        'Citroën',
        'Dodge',
        'Effa',
        'Exeed',
        'Ferrari',
        'Fiat',
        'Ford',
        'Foton',
        'Honda',
        'Hyundai',
        'Iveco',
        'JAC',
        'Jaguar',
        'Jeep',
        'Kia',
        'Lamborghini',
        'Land Rover',
        'Lexus',
        'Lifan',
        'Maserati',
        'McLaren',
        'Mercedes-AMG',
        'Mercedes-Benz',
        'Mini',
        'Mitsubishi',
        'Nissan',
        'Peugeot',
        'Porsche',
        'RAM',
        'Renault',
        'Rolls-Royce',
        'Shineray',
        'SsangYong',
        'Subaru',
        'Suzuki',
        'Toyota',
        'Troller',
        'Volkswagen',
        'Volvo',
    ]

    let formWrapper = document.createElement('section')
    formWrapper.classList = 'form-section'
    element.appendChild(formWrapper)

    let div = document.createElement('div')
    div.classList = 'form-wrapper'
    formWrapper.appendChild(div)

    let form = document.createElement('form')
    form.classList = 'car-form'
    div.appendChild(form)

    let select = document.createElement('select')
    select.id = 'brand'
    select.name = 'brand'
    form.appendChild(select)

    let option = document.createElement('option')
    option.text = 'Escolha a Marca'
    option.value = ''
    select.appendChild(option)

    for (let i = 0; i < carsBrand.length; i++) {
        let option = document.createElement('option')
        option.text = carsBrand[i]
        option.value = carsBrand[i]
        if (data.brand === carsBrand[i]) {
            option.setAttribute('selected','selected')
        }
        select.appendChild(option)
    }

    let inputModel = document.createElement('input')
    inputModel.id = 'model'
    inputModel.type = 'text'
    inputModel.name = 'model'
    inputModel.placeholder = 'Modelo'
    inputModel.value = data.model
    form.appendChild(inputModel)

    let inputYear = document.createElement('input')
    inputYear.id = 'year'
    inputYear.type = 'text'
    inputYear.name = 'year'
    inputYear.placeholder = 'Ano'
    inputYear.value = data.year
    form.appendChild(inputYear)

    let button = document.createElement('button')
    button.classList.add('form-button')
    button.type = 'submit'
    button.innerHTML = 'Atualizar Carro'
    form.appendChild(button)

    form.addEventListener( 'submit', (event) => {
        event.preventDefault()
        update(carId)
    })
}
