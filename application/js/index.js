import VanillaJSRouter from '../node_modules/@daleighan/vanilla-js-router/index.js'

import { Home } from './Components/Home.js'
import { Car } from './Components/Car.js'
import { NewCar } from './Components/NewCar.js'
import { EditCar } from './Components/EditCar.js'
import { DeleteCar } from './Components/DeleteCar.js'

const options = {
    debug: false,
    errorHTML: Home,
}

const routes = {
    '/home': Home,
    '/car/:id': Car,
    '/new': NewCar,
    '/edit/:id': EditCar,
    '/delete/:id': DeleteCar,
}

new VanillaJSRouter('root', routes, options)
