import styled from 'styled-components'

import { Row, Button } from 'react-bootstrap'

export const BoxCards = styled(Row)`
  padding: 1rem 0;
`
export const BtnControl = styled(Button)`
  position: relative;
  display: inline-block;
  width: 30px;
  height: 30px;
  padding: 0;
  border-radius: 50%;
  svg {
    position: relative;
    width: 26px;
    z-index: 4;
  }
  span {
    position: absolute;
    width: 10px;
    height: 24px;
    color: #666;
    top: 2px;
    left: 0px;
    opacity: 0;
    z-index: 3;
    overflow: hidden;
    transition: all ease-in-out 300ms;
  }

  &:hover {
    span {
      width: 80px;
      left: -80px;
      opacity: 1;
    }
  }
`
