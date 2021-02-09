import styled from 'styled-components'
import { Button, Card } from 'react-bootstrap'

export const CarCards = styled(Card)`
  color: #666;
  font-size: 14px;
  border-radius: 9px;
  border: 1px solid #f1f1f1;
  margin: 1rem 0;
  transition: all ease-in-out 300ms;

  img {
    border-radius: 9px 9px 0 0;
  }

  &:hover {
    transform: scale(1.02);
    box-shadow: 0px 1px 15px 0px rgba(0, 0, 0, 0.4);
  }
`

export const BtnControl = styled(Button)`
  display: inline-block;
  width: 30px;
  height: 30px;
  padding: 0;
  border-radius: 50%;
  svg {
    width: 26px;
  }
`
