import * as React from 'react'
import { useSelector } from 'react-redux'

import { FormControl } from '../../base-components'

function MakersSelect () {
  const makers = useSelector(state => state.makers)

  return (
    <FormControl
      label={{
        id: 'maker-select',
        textContent: 'Which company makes this model?'
      }}
      options={makers.data}
      placeholderLabel='Choose a manufacturer'
      type='select'
    />
  )
}

export default MakersSelect
