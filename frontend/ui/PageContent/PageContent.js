import * as React from 'react'

import { CardList, Form } from '../'

function PageContent ({ content = {} }) {
  const { cars, makers } = content

  return (
    <main className='max-width'>
      <Form selectOptions={makers} />
      <CardList listItems={cars} />
    </main>
  )
}

export default PageContent
