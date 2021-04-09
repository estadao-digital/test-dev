import { combineReducers } from 'redux'
import { reducer as formReducer } from 'redux-form'
import { reducer as toastrReducer } from 'react-redux-toastr'

import CarsReducer from 'reducers/carsReducer'

const rootReducer = combineReducers({
    cars: CarsReducer,
    form: formReducer,
    toastr: toastrReducer
})

export default rootReducer