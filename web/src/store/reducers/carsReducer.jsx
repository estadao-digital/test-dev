import * as types from 'types/carsType'

const INITIAL_STATE = {
    list: [],
    save: false
}

export default (state = INITIAL_STATE, action) => {
    switch (action.type) {
        case types.CARS_FETCHED:
            return { ...state, list: action.payload.data }
        case types.CARS_SAVE:
            return { ...state, save: action.payload }
        default:
            return state
    }
}