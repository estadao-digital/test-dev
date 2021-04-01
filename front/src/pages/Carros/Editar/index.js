import React from 'react';
import { useDispatch } from 'react-redux';
import { Modal } from 'react-bootstrap';
import { Form, Input, Select } from '@rocketseat/unform';
import * as Yup from 'yup';

import { updateCarRequest } from '../../../store/modules/carros/actions';

import { Container } from '../styles';

const schema = Yup.object().shape({
  marca: Yup.string().required('A marca é obrigatória'),
  modelo: Yup.string().required('O modelo é obrigatório'),
  ano: Yup.number().required('O ano é obrigatório'),
});

export default function Editar({ open, onChange, data, marcas }) {
  const dispatch = useDispatch();
  const { id } = data;
  function handleSubmit({ marca, modelo, ano }) {
    dispatch(updateCarRequest(id, { marca, modelo, ano }));
    onChange(!open);
  }

  return (
    <>
      {open && (
        <Modal show={open} onHide={onChange}>
          <Modal.Header closeButton>
            <Modal.Title>Cadastro de Carros</Modal.Title>
          </Modal.Header>
          <Modal.Body>
            <Container>
              <Form schema={schema} onSubmit={handleSubmit} initialData={data}>
                <Select name="marca" options={marcas} placeholder="Marcas" />
                <Input name="modelo" placeholder="Modelo" />
                <Input name="ano" type="number" placeholder="Ano" />

                <button type="submit">Salvar</button>
              </Form>
            </Container>
          </Modal.Body>
        </Modal>
      )}
    </>
  );
}
