import { Button, Form } from 'react-bootstrap'
const EditForm = ({ card }) => {
  return (
    <Form>
      <Form.Group controlId="formBasicTitle">
        <Form.Label>Título</Form.Label>
        <Form.Control
          type="text"
          placeholder="Digite o Título"
          defaultValue={card ? card.title : ''}
        />
        <Form.Text className="text-muted">Testo exemplo</Form.Text>
      </Form.Group>

      <Form.Group controlId="formBasicDescript">
        <Form.Label>Descriptção</Form.Label>
        <Form.Control
          as="textarea"
          rows={3}
          defaultValue={card ? card.descript : ''}
        />
      </Form.Group>

      <Form.Group controlId="formBasicMarca">
        <Form.Label>Marca</Form.Label>
        <Form.Control as="select" defaultValue={card ? card.mark : ''}>
          <option>Selecione uma Marca</option>
          <option value="Fiat">Fiat</option>
          <option value="Mazda">Mazda</option>
          <option value="Bugatti">Bugatti</option>
          <option value="Chevrolet">Chevrolet</option>
          <option value="Renault">Renault</option>
          <option value="JAC">JAC</option>
          <option value="Ford">Ford</option>
          <option value="Peugeot">Peugeot</option>
          <option value="Hyundai">Hyundai</option>
        </Form.Control>
      </Form.Group>

      <Form.Group controlId="formBasicModelo">
        <Form.Label>Modelo</Form.Label>
        <Form.Control
          type="number"
          placeholder="Digite o Modelo"
          defaultValue={card ? card.model : ''}
        />
      </Form.Group>

      <Form.Group controlId="formBasicPreco">
        <Form.Label>Preço</Form.Label>
        <Form.Control
          type="number"
          placeholder="Digite o Preço"
          defaultValue={card ? card.price : ''}
        />
      </Form.Group>

      <Form.Group>
        <Form.File id="exampleFormControlFile1" label="Selecione uma imagem" />
      </Form.Group>

      <Button variant="primary" type="submit">
        Submit
      </Button>
    </Form>
  )
}

export default EditForm
