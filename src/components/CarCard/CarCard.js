import { CarCards, BtnControl } from './styles'
import { Card, ListGroup, ListGroupItem } from 'react-bootstrap'

import Icons from '@/elements/Icons'
const CarCard = ({ car, typeForm, deleteCard }) => {
  const { Edit, Delete } = Icons

  return (
    <CarCards>
      <Card.Img variant="top" src={`/assets/img/${car.img}`} />
      <Card.Body>
        <Card.Title>{car.title}</Card.Title>
        <Card.Text>
          {car.descript.length >= 70
            ? car.descript.slice(0, 70) + ' ...'
            : car.descript}
        </Card.Text>
      </Card.Body>
      <ListGroup className="list-group-flush">
        <ListGroupItem>
          <strong>
            {car.mark} - {car.model}
          </strong>
        </ListGroupItem>
        <ListGroupItem>
          Preço <strong>R$ {car.price}</strong>
        </ListGroupItem>
      </ListGroup>
      <Card.Body className="d-flex justify-content-between">
        <BtnControl onClick={() => typeForm('edit')}>
          <Edit title="Edit Card" />
        </BtnControl>
        <BtnControl variant="danger" onClick={() => deleteCard(true)}>
          <Delete title="Delet Card" />
        </BtnControl>
      </Card.Body>
    </CarCards>
  )
}

export default CarCard
