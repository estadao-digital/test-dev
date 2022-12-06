import { Button, Form } from "react-bootstrap";
import { FaCheck } from "react-icons/fa";
import CustomHead from "../head";
import Link from "next/link";
import { useRouter } from 'next/router'

import { useState, useEffect } from 'react'


const UpdateCar: NextPage = () => {
  const router = useRouter()
  const { id } = router.query
  const url: string = `http://0.0.0.0/api/carros/${id}`
  const [loading, setLoading] = useState(false)
  const [data, setData] = useState(null)

  const fetchData = async (url: RequestInfo, method: string) => {
    try {
      setLoading(true)

      const response = await fetch(url, {
        "method": method
      })

      const data = await response.json()
      if (!data) throw 'No car found!'
      setData(data)

    } catch (error) {
      console.log("error: ", error);
    }
    finally {
      setLoading(false)
    }
  }

  useEffect(() => {
    fetchData(url, "GET")
  }, []);

  return (
    <>
      {CustomHead()}
      <div className="form-container">
        <h1>Update Car</h1>

        {loading && !data && }
        { }

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
    </>
  )
}

export default UpdateCar;