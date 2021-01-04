import { createSlice } from '@reduxjs/toolkit'

const carsSlice = createSlice({
  name: 'cars',
  reducers: {
    requestCarsList: state => {
      state.status = 'pending'
    },
    receiveCarsList: (state, action) => {
      state.status = !action.payload.error ? 'resolved' : 'rejected'
      state.data = action.payload.data
    },
    refreshCarsList: (state, action) => {
      state.status = !action.payload.error ? 'resolved' : 'rejected'
      state.data = action.payload.data
    }
  },
  initialState: {
    status: 'idle',
    error: false,
    data: []
  }
})

export const carsReducer = carsSlice.reducer
export const carsThunks = carsSlice.actions
