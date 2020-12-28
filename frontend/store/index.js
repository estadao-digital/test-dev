import React from 'react'
import { configureStore } from '@reduxjs/toolkit'
import { Provider } from 'react-redux'

import reducers from './reducers'

const store = configureStore({ reducer: reducers })

function Store ({ children }) {
  return <Provider store={store}>{children}</Provider>
}

export default Store
