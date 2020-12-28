import * as React from 'react'

import { FormControl } from '../../base-components'

function MakersSelect ({ makers = [] }) {
  return (
    <FormControl
      label={{
        id: 'maker-select',
        textContent: 'Which company  manufactures this model?'
      }}
      options={makers}
      type='select'
    />
  )
}

export default MakersSelect
