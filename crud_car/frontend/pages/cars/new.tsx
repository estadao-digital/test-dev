import { NextPage } from "next";
import { Button, Form, FormLabel } from "react-bootstrap";
import { FaCheck } from "react-icons/fa";

const NewCar: NextPage = () => {
  return (
    <div className="form-container">
      <h1>New Car</h1>
      <Form method="post" action="http://0.0.0.0/api/carros">
        <label htmlFor="brand">Car Brand: </label>
        <input type="text" id="brand" name="brand" />
        <br />
        <label htmlFor="model">Car Model: </label>
        <input type="text" id="model" name="model" />
        <br />
        <label htmlFor="year">Car Model's Year: </label>
        <input type="number" placeholder="yyyy" min="1900" max="2099" step="1" id="year" name="year" />
        <br />
        <Button variant="primary" type="submit">Submit <FaCheck /></Button>
      </Form>
    </div>
  )
}

export default NewCar;