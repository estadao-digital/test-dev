import { createSlice } from '@reduxjs/toolkit'

const makersSlice = createSlice({
  name: 'makers',
  reducers: {
    requestMakersList: state => {
      state.status = 'pending'
    },
    receiveMakersList: (state, action) => {
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

export const makersReducer = makersSlice.reducer
export const makersThunks = makersSlice.actions
