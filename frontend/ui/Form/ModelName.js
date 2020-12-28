import * as React from 'react'

import { FormControl } from '../../base-components'

function ModelName ({ onChange }) {
  return (
    <FormControl
      label={{
        id: 'model-name',
        textContent: `What's its name?`
      }}
      aria-label='Inform the name of the car model'
      maxLength='100'
      name='model'
      onChange={onChange}
      required
      tabIndex='0'
      type='text'
    />
  )
}

export default ModelName
