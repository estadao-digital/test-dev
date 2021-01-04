import { carsThunks } from './slices/carsSlice'
import { makersThunks } from './slices/makersSlice'

export const { requestCarsList, receiveCarsList, refreshCarsList } = carsThunks
export const { requestMakersList, receiveMakersList } = makersThunks
