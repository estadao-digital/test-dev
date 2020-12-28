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
  const [isEditing, setIsEditing] = React.useState(false)
  const cars = useSelector(state => state.cars)

  const handleEdit = id => {
    setIsEditing(cars.data.find(({ id: carId }) => id === carId))
  }

  const handleRemove = async id => {
    try {
      await CarsApi.removeEntry(id)
    } finally {
      const newList = cars.data.filter(({ id: carId }) => id !== carId)

      dispatch(refreshCarsList({ data: newList }))
    }
  }

  const handleSubmit = async ({ id, ...formData }) => {
    let newItem

    try {
      if (id) {
        const { data } = await CarsApi.updateEntry(id, formData)
        newItem = data
      } else {
        const { data } = await CarsApi.createEntry(formData)
        newItem = data
      }
    } finally {
      let newList

      if (id) {
        const filteredList = cars.data.filter(({ id: carId }) => id !== carId)

        dispatch(refreshCarsList({ data: [...filteredList, newItem] }))
        setIsEditing(false)
      } else {
        dispatch(refreshCarsList({ data: [...cars.data, newItem] }))
      }
    }
  }

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
    <AppContext.Provider
      value={{ handleEdit, handleRemove, handleSubmit, isEditing }}
    >
      {children}
    </AppContext.Provider>
  )
}

export default AppContextProvider
