import * as React from 'react'

function InputText ({ onChange, ...props }) {
  const handleChange = e => {
    onChange({ [props.name]: e.target.value })
  }

  return <input {...props} type='text' onChange={handleChange} />
}

export default InputText
