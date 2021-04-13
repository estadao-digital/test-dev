import { combineReducers } from 'redux'
import { reducer as formReducer } from 'redux-form'
import { reducer as toastrReducer } from 'react-redux-toastr'

import CarsReducer from 'reducers/carsReducer'
import BrandsReducer from 'reducers/brandsReducer'

const rootReducer = combineReducers({
    cars: CarsReducer,
    brands: BrandsReducer,
    form: formReducer,
    toastr: toastrReducer
})

export default rootReducer