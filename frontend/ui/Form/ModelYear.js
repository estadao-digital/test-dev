import * as React from 'react'

import { FormControl } from '../../base-components'

function ModelYear () {
  return (
    <FormControl
      label={{
        id: 'model-year',
        textContent: `What is the model's year?`
      }}
      type='text'
      maxLength='4'
      tabIndex='0'
      aria-label='Inform the year of this model'
      required
    />
  )
}

export default ModelYear
