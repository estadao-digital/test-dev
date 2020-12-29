import * as React from 'react'
import { useSelector } from 'react-redux'

import { FormControl } from '../../base-components'

function MakersSelect ({ onChange, value }) {
  const { data: options } = useSelector(state => state.makers)

  return (
    <FormControl
      label={{
        id: 'maker-select',
        textContent: 'Which company makes this model?'
      }}
      name='makerId'
      options={options}
      placeholderLabel='Choose a manufacturer'
      type='select'
      onChange={onChange}
      value={value}
    />
  )
}

export default MakersSelect
