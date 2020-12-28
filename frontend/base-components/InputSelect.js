import * as React from 'react'

function InputSelect ({ placeholderLabel, options, ...props }) {
  return (
    <select {...props}>
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
