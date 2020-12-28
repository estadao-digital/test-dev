import * as React from 'react'
import { useDispatch as useReduxDispatch, useSelector } from 'react-redux'

import { CarsApi, MakersApi } from '../../api'
import {
  requestCarsList,
  receiveCarsList,
  refreshCarsList,
  requestMakersList,
  receiveMakersList
} from '../../store/thunks'
import AppContext from './'

function AppContextProvider ({ children }) {
  const dispatch = useReduxDispatch()
  const cars = useSelector(state => state.cars)
  const makers = useSelector(state => state.makers)

  React.useEffect(() => {
    ;(async () => {
      dispatch(requestCarsList())
      dispatch(requestMakersList())

      const [carsData, makersData] = await Promise.all([
        CarsApi.takeAll(),
        MakersApi.takeAll()
      ])

      if (carsData.data.length && makersData.data.length) {
        const carsList = carsData.data.map(({ id, makerId, ...car }) => ({
          ...car,
          id,
          maker: makersData.data.find(({ id }) => id === makerId).maker
        }))

        const makersList = makersData.data.map(({ id, maker }) => ({
          value: id,
          label: maker
        }))

        dispatch(receiveCarsList({ data: carsList }))
        dispatch(receiveMakersList({ data: makersList }))
      }
    })()
  }, [dispatch])

  return (
    <AppContext.Provider value={{ cars, makers }}>
      {children}
    </AppContext.Provider>
  )
}

export default AppContextProvider
