import React from 'react';
import { useDispatch } from 'react-redux';
import { Modal, Button } from 'react-bootstrap';

import { removeCar } from '../../../store/modules/carros/actions';

import { Container } from '../styles';

export default function Deletar({ open, onChange, data }) {
  const dispatch = useDispatch();
  const { id } = data;
  function handleDelete() {
    dispatch(removeCar(id));
    onChange(!open);
  }

  return (
    <>
      {open && (
        <Modal show={open} onHide={onChange}>
          <Modal.Header closeButton>
            <Modal.Title>Deletar registro</Modal.Title>
          </Modal.Header>
          <Modal.Body>
            <Container>
              <h3>
                Tem certeza que deseja deletar o carro: {data.modelo}/{data.ano}
                , marca: {data.nome_marca}
              </h3>
            </Container>
          </Modal.Body>
          <Modal.Footer>
            <Button variant="danger" block onClick={() => handleDelete()}>
              Deletar
            </Button>
          </Modal.Footer>
        </Modal>
      )}
    </>
  );
}
