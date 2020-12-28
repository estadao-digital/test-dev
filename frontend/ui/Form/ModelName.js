import * as React from 'react'

import { FormControl } from '../../base-components'

function ModelName () {
  return (
    <FormControl
      label={{
        id: 'model-name',
        textContent: `What's its name?`
      }}
      type='text'
      maxLength='100'
      tabIndex='0'
      aria-label='Inform the name of the car model'
      required
    />
  )
}

export default ModelName
