import * as React from 'react'

import { Button } from '../../base-components'

function ActionButton ({ children, ...props }) {
  return (
    <Button onClick={() => console.log(children)} {...props}>
      {children}
    </Button>
  )
}

export default ActionButton
