import * as React from 'react'

import { InputSelect, InputText } from '.'

function FormControl ({ label, type, ...inputProps }) {
  return (
    <div className={`${type}-input-group`}>
      <label className='input-label' htmlFor={label.id}>
        {label.textContent}
      </label>
      {
        {
          text: <InputText {...inputProps} />,
          select: <InputSelect {...inputProps} />
        }[type]
      }
    </div>
  )
}

export default FormControl
