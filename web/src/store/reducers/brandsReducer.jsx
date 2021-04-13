import * as types from 'types/brandsType'

const INITIAL_STATE = {
    list: []
}

export default (state = INITIAL_STATE, action) => {
    switch (action.type) {
        case types.BRANDS_FETCHED:
            return { ...state, list: action.payload }
        default:
            return state
    }
}