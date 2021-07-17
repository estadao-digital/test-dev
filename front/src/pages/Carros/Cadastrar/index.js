import React from 'react';
import { useDispatch } from 'react-redux';
import { Modal } from 'react-bootstrap';
import { Form, Input, Select } from '@rocketseat/unform';
import * as Yup from 'yup';
import { format } from 'date-fns';
import { addCarRequest } from '../../../store/modules/carros/actions';

import { Container } from '../styles';

const ano = parseInt(format(new Date(), 'yyyy')) + 2;
const schema = Yup.object().shape({
  marca: Yup.string().required('A marca é obrigatória'),
  modelo: Yup.string().required('O modelo é obrigatório'),
  ano: Yup.number()
    .min(1900, 'O ano minimo deve ser 1886')
    .max(ano, `O ano máximo deve ser ${ano}`)
    .required('O ano é obrigatório'),
});

export default function Cadastrar({ open, onChange, marcas }) {
  const dispatch = useDispatch();

  function handleSubmit({ marca, modelo, ano }) {
    dispatch(addCarRequest({ marca, modelo, ano }));
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
              <Form schema={schema} onSubmit={handleSubmit}>
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
