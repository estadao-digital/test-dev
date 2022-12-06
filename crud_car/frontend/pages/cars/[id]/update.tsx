import { Button, Form, FormLabel } from "react-bootstrap";
import { FaCheck } from "react-icons/fa";

const UpdateCar: NextPage = () => {
  return (
    <div className="form-container">
      <h1>New Car</h1>
      <Form method="post" action="http://0.0.0.0/api/carros">
        <label for="brand">Car Brand: </label>
        <input type="text" id="brand" name="brand" />
        <br />
        <label for="model">Car Model: </label>
        <input type="text" id="model" name="model" />
        <br />
        <label for="year">Car Model's Year: </label>
        <input type="number" placeholder="yyyy" min="1900" max="2099" step="1" id="year" name="year" />
        <br />
        <Button variant="primary" type="submit">Submit {FaCheck()}</Button>
      </Form>
    </div>
  )
}

export default UpdateCar;