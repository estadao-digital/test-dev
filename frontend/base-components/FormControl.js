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
          text: <InputText {...inputProps} id={label.id} />,
          select: <InputSelect {...inputProps} id={label.id} />
        }[type]
      }
    </div>
  )
}

export default FormControl
