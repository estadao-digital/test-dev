import * as React from 'react'

import { FormControl } from '../../base-components'

function ModelYear ({ onChange }) {
  return (
    <FormControl
      label={{
        id: 'model-year',
        textContent: `What is the model's year?`
      }}
      aria-label='Inform the year of this model'
      maxLength='4'
      name='year'
      onChange={onChange}
      required
      tabIndex='0'
      type='text'
    />
  )
}

export default ModelYear
