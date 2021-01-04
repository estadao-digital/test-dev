import * as React from 'react'

function useFormReducer (initialState, init) {
  function formReducer (state, action) {
    switch (action.type) {
      case 'init':
        return init(action.payload)
      default:
        return { ...state, ...action }
    }
  }

  return React.useReducer(formReducer, initialState, init)
}

export default useFormReducer
