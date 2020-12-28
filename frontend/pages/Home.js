import * as React from 'react'

import { CarsApi, MakersApi } from '../api'
import { PageContent, PageHeader } from '../ui'

function Home () {
  const [cars, setCars] = React.useState([])
  const [makers, setMakers] = React.useState([])

  React.useEffect(() => {
    ;(async () => {
      const [cars, makers] = await Promise.all([
        CarsApi.takeAll(),
        MakersApi.takeAll()
      ])

      if (cars.data.length && makers.data.length) {
        const carsList = cars.data.map(({ id, makerId, ...car }) => ({
          ...car,
          id,
          maker: makers.data.find(({ id }) => id === makerId).maker
        }))

        const makersList = makers.data.map(({ id, maker }) => ({
          value: id,
          label: maker
        }))

        setCars(carsList)
        setMakers(makersList)
      }
    })()
  }, [])

  return (
    <>
      <PageHeader />
      <PageContent content={{ cars, makers }} />
    </>
  )
}

export default Home
