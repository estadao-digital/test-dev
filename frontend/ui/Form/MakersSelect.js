import * as React from 'react'
import { useSelector } from 'react-redux'

import { FormControl } from '../../base-components'

function MakersSelect ({ onChange }) {
  const makers = useSelector(state => state.makers)

  return (
    <FormControl
      label={{
        id: 'maker-select',
        textContent: 'Which company makes this model?'
      }}
      name='makerId'
      options={makers.data}
      placeholderLabel='Choose a manufacturer'
      type='select'
      onChange={onChange}
    />
  )
}

export default MakersSelect
