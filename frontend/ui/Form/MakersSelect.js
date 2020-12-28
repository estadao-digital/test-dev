import * as React from 'react'

import { FormControl } from '../../base-components'

function MakersSelect ({ makers = [] }) {
  return (
    <FormControl
      label={{
        id: 'maker-select',
        textContent: 'Which company makes this model?'
      }}
      options={makers}
      placeholderLabel='Choose a manufacturer'
      type='select'
    />
  )
}

export default MakersSelect
