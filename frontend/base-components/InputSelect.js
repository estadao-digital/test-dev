import * as React from 'react'

function InputSelect ({ onChange, options, placeholderLabel, ...props }) {
  const handleChange = e => {
    onChange({ [props.name]: e.target.value })
  }

  return (
    <select {...props} onChange={handleChange}>
      <option value=''>
        {!!placeholderLabel ? placeholderLabel : 'Choose an option'}
      </option>
      {options.map(({ label, value }) => (
        <option key={value} value={value}>
          {label}
        </option>
      ))}
    </select>
  )
}

export default InputSelect
