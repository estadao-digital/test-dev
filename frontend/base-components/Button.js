import * as React from 'react'

function Button ({ children, ...props }) {
  return <button {...props}>{children}</button>
}

export default Button
