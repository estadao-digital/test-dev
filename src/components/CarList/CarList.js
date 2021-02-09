import { useState, useEffect } from 'react'
import { CarCard, EditForm } from '@/components'
import { BoxCards, BtnControl } from './styles'
import { Col, Modal, Button } from 'react-bootstrap'
import Icons from '@/elements/Icons'

import CARS from '@/data/cars.json'
const CarList = () => {
  const { Add } = Icons
  const [dataCars, setDataCars] = useState(null)
  const [editModal, setEditModal] = useState(false)
  const [deleteModal, setDeleteModal] = useState(false)
  const [formType, setFormType] = useState(null)
  const [cardSelected, setCardSelected] = useState(null)

  useEffect(() => {
    CARS.length > 0 ? setDataCars(CARS) : ''
  }, [])

  return (
    <>
      <BoxCards>
        <Col sm={12} md={12} className="d-flex justify-content-end">
          <BtnControl
            variant="success"
            onClick={() => {
              setEditModal(true)
              setFormType('add')
            }}
          >
            <Add title="Add Card" />
            <span>Add Card</span>
          </BtnControl>
        </Col>

        {dataCars !== null ? (
          dataCars.map((car) => {
            return (
              <Col sm={12} md={4} key={car.id}>
                <CarCard
                  car={car}
                  typeForm={(typeF) => {
                    setFormType(typeF)
                    setEditModal(true)
                    setCardSelected(car)
                  }}
                  deleteCard={(value) => {
                    setDeleteModal(value)
                    setCardSelected(car)
                  }}
                />
              </Col>
            )
          })
        ) : (
          <h1>Sem dados</h1>
        )}
      </BoxCards>
      <Modal
        show={editModal}
        onHide={() => {
          setEditModal(false)
          setCardSelected(null)
        }}
      >
        <Modal.Header closeButton>
          <Modal.Title>
            {formType === 'add' && formType !== null
              ? 'Adicionar um novo Card'
              : 'Editar Card'}
          </Modal.Title>
        </Modal.Header>
        <Modal.Body>
          <EditForm card={cardSelected} />
        </Modal.Body>
      </Modal>
      <Modal
        show={deleteModal}
        onHide={() => {
          setDeleteModal(false)
          setCardSelected(null)
        }}
      >
        <Modal.Header closeButton>
          <Modal.Title>Realmente deseja Apagar o card?</Modal.Title>
        </Modal.Header>
        <Modal.Body className="d-flex justify-content-around">
          <Button
            variant="danger"
            onClick={() => {
              setTimeout(() => {
                setDeleteModal(false)
              }, 300)
              console.log('card deletado---->', cardSelected)
            }}
          >
            Deletar
          </Button>{' '}
          <Button
            variant="secondary"
            onCLick={() => {
              setDeleteModal(false)
              setCardSelected(null)
            }}
          >
            Cnacelar
          </Button>
        </Modal.Body>
      </Modal>
    </>
  )
}

export default CarList
