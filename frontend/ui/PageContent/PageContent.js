import * as React from 'react'
import { useSelector } from 'react-redux'

import { CardList, Form } from '../'

function PageContent () {
  const cars = useSelector(state => state.cars)

  return (
    <main className='max-width'>
      <Form />
      {!!(cars.status === 'resolved') && <CardList listItems={cars.data} />}
    </main>
  )
}

export default PageContent
