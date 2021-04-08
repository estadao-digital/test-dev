import * as types from '../types/carsType'

const INITIAL_STATE = {
    list: []
}

export default (state = INITIAL_STATE, action) => {
    switch (action.type) {
        case types.CARS_FETCHED:
            return { ...state, list: action.payload.data }
        default:
            return state
    }
}